<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\AttributeSet;
use App\Models\Category;

use Datatables;
use DB;

use ValidatesRequests;

class AttributeSetController extends Controller {

    public $AttributeSetobj;
    
    public function __construct() {        
        $this->AttributeSetobj = new AttributeSet();   
        $this->categoryobj=new category();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
       
        $attributeset = AttributeSet::paginate(15);
        
        return view('admin.attributeset.index', compact($attributeset ));
    }

    public function datatableList(Request $request) {
        
        $attributeset = $this->AttributeSetobj->getdatatablelist();
       
        return Datatables::of($attributeset)
                        ->addColumn('action', function ($attribute) {
                            return '<a href="' . route(config('project.admin_route').'attributeset.edit', encrypt($attribute->id)) . '" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>' .
                                    '&nbsp;&nbsp;<a href="javascript:void(0)" class="btn btn-danger btn-xs fa fa-trash-o deleteAttributeSet" data-toggle="modal" data-placement="top" title="Delete" data-attributeset_delete_remote="' . route(config('project.admin_route').'attributeset.destroy', encrypt($attribute->id)) . '"></a>';
                        })
                        //'<button class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="Delete User" data-message="Are you sure you want to delete this user ?"><i class="glyphicon glyphicon-trash"></i> Delete</button>';                        
                        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $input['all_attributeset'] = AttributeSet::pluck('id','attribute_set_name','attribute_set_description')->all();        
        $input['all_categories'] = $this->categoryobj->getNestedData();
        $input['attribute_cat'] = NULL;
        unset($input['all_categories'][0]);
        return view('admin.attributeset.create', compact('input'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {     
        $messsages = array(
            'attribute_set_categoryid.*.required'=>'Category can not be empty. Please remove first empty category.',
        );
        $this->validate($request, [
            'attribute_set_name' => 'required|string|max:255|unique:attribute_sets,attribute_set_name',
            'attribute_set_description' => 'required|string',
            'attribute_set_categoryid.0' => 'required',
        ],$messsages);

        $data = $request->only('attribute_set_name', 'attribute_set_description');        
        $res_attri_set = $this->AttributeSetobj->create($data);
        
        $data_values = $request->only('attribute_set_categoryid');
        $cat_res = $this->AttributeSetobj->insertattricategory($data_values['attribute_set_categoryid'],$res_attri_set['id']);
        
        if($cat_res && $res_attri_set)
        {      
            \Flash::success(trans('attributeset.add_success'));
            if ($request->ajax()) {
                return response()->json([
                            'status' => 'success',
                            'redirectUrl' => route(config('project.admin_route').'attributeset.index'),
                ]);
            } else {
                return redirect()->route(config('project.admin_route').'attribute.index');
            }
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
        $id = decrypt($id);
        $input = array();
        //echo '<pre>';
        $input = $this->AttributeSetobj->getdatatodisplay($id);
        
        $input['all_categories'] = $this->categoryobj->getNestedData();
        unset($input['all_categories'][0]);
        //print_r($input);
        return view('admin.attributeset.edit', compact('input'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $id = decrypt($id);
        $result = $this->AttributeSetobj->findOrFail($id);
                
        $messsages = array(
            'attribute_set_categoryid.*.required'=>'Attribute Set can not be empty',
        );
        
        //check valication
        $this->validate($request, [
            'attribute_set_name' => 'required|string|max:255|unique:attribute_sets,attribute_set_name,'.$result->id,
            'attribute_set_description' => 'required|string',
             'attribute_set_categoryid.*' => 'required',
        ],$messsages);
        
        $data = $request->only('attribute_set_name', 'attribute_set_description');        
        $attr_res = $result->update($data);
        
        $this->AttributeSetobj->deleteattrisetcat($id);        
        $data_values = $request->only('attribute_set_categoryid');        
        $cat_res = $this->AttributeSetobj->insertattricategory($data_values['attribute_set_categoryid'],$id);
              
        if($attr_res && $cat_res)
        {
            
            \Flash::success(trans('attributeset.update_success'));
            if ($request->ajax()) {
                return response()->json([
                            'status' => 'success',
                            'redirectUrl' => route(config('project.admin_route').'attributeset.index'),
                ]);
            } else {
                return redirect()->route(config('project.admin_route').'attributeset.index');
            }
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request) {
        $id = decrypt($id);

        try {
            $data = $this->AttributeSetobj->findOrFail($id)->delete();
            if ($request->ajax()) {
                return response(['msg' => trans('attributeset.delete_success'), 'success' => 1]);
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            return response(['msg' => $ex->errorInfo, 'success' => 0]);            
        }
        
    }

}
