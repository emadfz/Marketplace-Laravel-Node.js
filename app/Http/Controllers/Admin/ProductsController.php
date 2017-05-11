<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use Datatables;
use App\Models\Files;
use DB;

class ProductsController extends Controller {

    public $category;

    public function __construct() {
        $this->category = new Category();
        $this->product = new Product();
    }

    public function datatableList(Request $request) {
        $products = $this->product->getProduct();                
        return Datatables::of($products)
                        ->addColumn('action', function ($product) {
                            return getAuthorizedButton($product);
                        })
                        ->editColumn('description', '{!! str_limit($description, 40) !!}')
                        ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {        
        return view('admin.products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $categories = $this->category->getNestedData();
        unset($categories[0]);
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request) {
        try {

            $data = $request->except('photo','_token');            
            if ($request->ajax()) {
                $photo = array();
                if ($request->hasFile('photo')) {
                    $photo = uploadImage($request->file('photo'), true);
                }
            }
            $product = $this->product->saveProduct($data, $photo);
            \Flash::success(trans('message.product.add_success'));
            if ($request->ajax()) {
                return response()->json([
                            'status' => 'success',
                            'redirectUrl' => route(config('project.admin_route') . 'products.index'),
                ]);
            } else {
                \Flash::success(trans('message.failure'));
                return response()->json([
                            'status' => 'error',
                            'redirectUrl' => route(config('project.admin_route') . 'products.index'),
                ]);
            }
        } catch (\Exception $e) {
            //echo $e->getMessage();die;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {        
        $categories = $this->category->getNestedData();
        unset($categories[0]);        
        $product=$this->product->getProduct(decrypt($id));                
        return view('admin.products.edit', compact('product','categories','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id) {

        
        try {
            $id = decrypt($id);
            $data = $request->except('_token');                                    
            if ($this->product->saveProduct($data ,$id)) {
                \Flash::success(trans('message.product.update_success'));
                return response()->json([
                            'status' => 'success',
                            'redirectUrl' => route(config('project.admin_route') . 'products.index'),
                ]);
            } else {
                \Flash::success(trans('message.failure'));
                return response()->json([
                            'status' => 'error',
                            'redirectUrl' => route(config('project.admin_route') . 'products.index'),
                ]);
            }
        } catch (\Exception $e) {
            //echo $e->getMessage();die;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        try{
        $id = decrypt($id);        
        $product=$this->product->getProduct($id);
        if($product->Files->count()>0){
            unsetImages($product->Files[0]->path);            
        }
                
        
        \Flash::success(trans('message.product.delete_success'));
            if ($this->product->deleteProduct($id)) {
                return response()->json([
                            'status' => 'success',
                            'redirectUrl' => route(config('project.admin_route').'products.index'),
                            'msg'=>trans('message.product.delete_success')
                ]);
            } else {
                return redirect()->route(config('project.admin_route').'products.index');
            }
            
        }
        catch(\Exception $e){
            return redirect()->route(config('project.admin_route').'products.index');
        }
          
        
    }

    public function uploadImage(Request $request,$id){        
        $files['file']=$request->file('files')[0];
        $validator = \Validator::make($files,['file' => 'mimes:jpg,jpeg,png|max:1024']);
        
        $errors = $validator->errors();        
        if($errors->count()>0){             
            $image['files'][0]['error']=$errors->first('file');
            return  response()->json($image);
        }
        
        
//         $this->validate($request, [
//            'files.0' => 'mimes:jpg,jpeg,png|max:14'//'dimensions:min_width=100,min_height=200
//            //'video' => 'mimetypes:video/avi,video/mpeg,video/quicktime'
//        ])->withErrors($validator, 'test');
        
        $data=$request->all();                
        $id = decrypt($id);        
        $product=$this->product->getProduct($id);                
        $images = uploadImage($request->file('files'), true);                
        $file=$product->Files()->create($images);        
        
        if($file->count()>0){            
                        $head = array_change_key_case(get_headers(getImageFullPath($file->path,'main'), TRUE));
                        $bytes = $head['content-length'];
                        $image['files'][0]['name']=$file->path;
                        $image['files'][0]['size']=(int)$bytes;        
                        $image['files'][0]['deleteType']="DELETE";        
                        $image['files'][0]['deleteUrl']=route(config('project.admin_route').getCurrentModuleName().'.deleteImage',encrypt($file->id));
                        $image['files'][0]['url']=getImageFullPath($file->path,'main');
            
        }
        
        
        return  response()->json($image);
    }
    public function getImage($id){             
        $id = decrypt($id);        
        $product=$this->product->getProduct($id);                        
        $image=array();
        if($product->Files->count()>0){
            foreach($product->Files as $key=>$file){                        
                        $head = array_change_key_case(get_headers(getImageFullPath($file->path,'main'), TRUE));                        
                        
                        if(isset($head['content-length']) && !empty($head['content-length']))
                        {
                            $bytes = $head['content-length'];
                        }
                        else{
                            $bytes = '';
                        }
                        
                        $image['files'][$key]['name']=$file->path;
                        $image['files'][$key]['size']=(int)$bytes;        
                        $image['files'][$key]['deleteType']="DELETE";        
                        $image['files'][$key]['deleteUrl']=route(config('project.admin_route').getCurrentModuleName().'.deleteImage',encrypt($file->id));
                        $image['files'][$key]['url']=getImageFullPath($file->path,'main');
            }   
        }
        return response()->json($image);        
    }
    public function deleteImage($file_id){     
        try{
            $file_id = decrypt($file_id);             
            $file=Files::getFileById($file_id);        
            if(isset($file) && count($file)){
                if(file_exists(getImageAbsolutePath($file->path,'main'))){
                    unlink(getImageAbsolutePath($file->path,'main'));
                }
                if(file_exists(getImageAbsolutePath($file->path,'small'))){
                        unlink(getImageAbsolutePath($file->path,'small'));
                }
                if(file_exists(getImageAbsolutePath($file->path,'thumbnail'))){
                        unlink(getImageAbsolutePath($file->path,'thumbnail'));
                }
                $file->delete();
                return  response()->json($file->path);     
            }
            else{
                return  response()->json('');     
            }
        }
        catch(\Exception $e){
            return  response()->json('ERROR');     
        }
        
    }

}

