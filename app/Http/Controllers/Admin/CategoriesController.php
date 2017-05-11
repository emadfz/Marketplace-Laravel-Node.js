<?php

/**
 * Category controller to manage N level tree operations
 *
 * A basic category tree structure with nested N level of implementation
 * move node by drag and drop functionality 
 *
 * Developed BY : Ronak Dattani
 *  
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ProductConditions;
use App\Http\Requests\CategoryRequest;

class CategoriesController extends Controller {

    public $category;

    public function __construct() {
        $this->category = new Category();
        $this->productconditions = new ProductConditions();        
    }

    /**
     * Show the admin category landing page
     *     
     * @return Response HTML
     */
    public function index() {
        return view('admin.category.index');
    }

    /**
     * AJAX call to get all neste nodes 
     *     
     * @return Response json object (nested structure)
     * 
     */
    public function getNode() {
        $root = $this->category->getChildNode();
        return response()->json($root);
    }

    /**
     * AJAX call to get content of particular clicked node
     * @param id of particular node which has been clicked
     * @return json object(content of particular node with html generated)
     */
    public function getContent($id) {
        $data = array();
        $node = $this->category->getNode($id);

        $data['content'] = \View::make('admin.category.category_content', compact('node'))->render();
        return response()->json($data);
    }

    /**
     * AJAX call to create new nede
     * @param Request object with id and text(name) of new node
     * @return JSON object of newly created node
     */
    public function create(request $request) {
        try {
            $requestObject = $request->all();
            $node = $this->category->createNode($requestObject);
            return response()->json(
                            array(
                                'data' => $node,
                                'msg' => trans('message.category.add_success')
                            )
            );
        } catch (\Exception $e) {
            return response()->json(
                            array(
                                'msg' => 'Something Went wrong!!'
                            )
            );
        }
    }

    /**
     * AJAX call to Rename the particular clicked node
     * @param Request object with selected node detail
     * @return \Illuminate\Http\Response
     */
    public function renameNode(request $request) {
        try {
            
            $requestObject = $request->all();                                    
            
            if (!is_numeric($requestObject['id'])) {
                unset($requestObject['id']);
            }            
            if (!is_numeric($requestObject['parent_id'])) {
                $requestObject['parent_id']=0;
            }                        
            $node = $this->category->renameNode($requestObject);

            return response()->json(
                            array(
                                'msg' => trans('message.category.rename_success')
                            )
            );
        } catch (\Exception $e) {
            echo $e->getMessage();
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
     * Remove the specified node from the storage
     *
     * @param selected node id int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id) {        
        if($id=='j1_1' ||  $id=='0'){
            
            return response()->json(
                            array(
                                'data'=>'',
                                'status'=>'error',
                                'msg' => 'You can not delete ROOT category!!'
                            )
            );
        }   

        $node = $this->category->deleteNode($id);
        return response()->json(
                        array(
                            'data' => $node,
                            'msg' => trans('message.category.delete_success')
                        )
        );
    }

    /**
     * Move node from one root to another root operation
     *
     * @return \Illuminate\Http\Response
     */
    public function moveNode($id, $parentId) {
        $node = $this->category->moveNode($id, $parentId);
        return response()->json(
                        array(
                            'data' => $node,
                            'msg' => trans('message.category.move_success')
                        )
        );
    }

    /**
     * Copy node from one root to another root operation
     *
     * @return \Illuminate\Http\Response
     */
    public function copyNode($id, $parentId) {
        $node = $this->category->copyNode($id, $parentId);
        return response()->json(
                        array(
                            'data' => $node,
                            'msg' => trans('message.category.copy_success')
                        )
        );
    }

    /**
     * Toggle category status 
     *
     * @return \Illuminate\Http\Response
     */
    public function toggleCategoryStatus($categoryId) {
        try {
            $this->category->toggleCategoryStatus($categoryId);
            return response()->json(
                            array(
                                'success' => 1,
                                'msg' => trans('message.category.status_success')
                            )
            );
        } catch (\Exception $e) {
            return response()->json(
                            array(
                                'error' => 1,
                                'msg' => trans('message.failure')
                            )
            );
        }
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {        
          $category = $this->category->getCategory($id);          
          $product_conditions = $this->productconditions->getProductConditions(false);          

          $product_conditions = $product_conditions->pluck('name','id');          
          return view('admin.category.edit', compact('category','product_conditions'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id) {
        try {                               
            //$id=decrypt($id);
            $data=$request->except('_method','_token','image');            
            $data['scope']=implode(',',$data['scope']);            
            if ($request->ajax()) {
                    $image='';
                if ($request->hasFile('image')) {                                        
                    if (isset($request->old_image) && !empty($request->old_image)) {                        
                        $image = uploadImage($request->file('image'),true,$request->old_image);
                    }
                    else{                        
                        $image = uploadImage($request->file('image'),true);                        
                        
                    }
                }
                
                
                unset($data['old_image']);                
                if ($this->category->saveCategoryDetail($data, $id,$image)) {
                    \Flash::success(trans('message.category.update_success'));
                    return response()->json([
                                'status' => 'success',
                                'redirectUrl' => route(config('project.admin_route') . 'category.index'),
                    ]);
                } else {
                    \Flash::success(trans('message.failure'));
                    return response()->json([
                                'status' => 'error',
                                'redirectUrl' => route(config('project.admin_route') . 'category.index'),
                    ]);
                }
            } else {
                return redirect()->route(config('project.admin_route') . 'category.index');
            }
        } catch (\Exception $e) {
            //echo $e->getMessage();die;
        }
     
    }

    public function commissionFeesList($scope = 'Products') {
        /*$commissionFeesCategoryWise = $this->category->getCommissionFeesOfCategories($scope);

        foreach ($commissionFeesCategoryWise AS $key => $category) {
            $commissionFeesCategoryWise[$key] = $category;
            if(checkAuthorize(array('commissionfees'),'update_access')){
                $commissionFeesCategoryWise[$key]->action = '<a data-target="#commissionfees_ajax_modal_popup" data-toggle="modal" href="' . route('editCommissionFees', [encrypt($category->id), $scope]) . '" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>';
            }else{
                $commissionFeesCategoryWise[$key]->action = '';
            }
        }

        $commissionFeesCategoryWise = collect($commissionFeesCategoryWise)->toJson();*/
        
        return view('admin.commissionfees.index', compact('scope'));
    }

    public function datatableCommissionFeesList(Request $request, $scope) {
        /*$commissionFeesCategoryWise = $this->category->getCommissionFeesOfCategories($scope);

        foreach ($commissionFeesCategoryWise AS $key => $category) {
            $commissionFeesCategoryWise[$key] = $category;
            if(checkAuthorize(array('commissionfees'),'update_access')){
                $commissionFeesCategoryWise[$key]->action = '<a data-target="#commissionfees_ajax_modal_popup" data-toggle="modal" href="' . route('editCommissionFees', [encrypt($category->id), $scope]) . '" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>';
            }else{
                $commissionFeesCategoryWise[$key]->action = '';
            }
        }

        return $commissionFeesCategoryWise = collect($commissionFeesCategoryWise)->toJson();*/
        
        $commissionFeesCategoryWise = $this->category->getCommissionFeesOfCategories($scope);
        $categories = collect($commissionFeesCategoryWise);
                
        $hasPermissionUpdate = FALSE;        
        if(checkAuthorize('commissionfees','update_access')){
            $hasPermissionUpdate = TRUE;
        }
        return \Datatables::of($categories)
                ->addColumn('action', function ($category) use ($hasPermissionUpdate, $scope) {
                            return $hasPermissionUpdate ? '<a data-target="#commissionfees_ajax_modal_popup" data-toggle="modal" href="' . route('editCommissionFees', [encrypt($category->id), $scope]) . '" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>':'';
                        })
                ->make(true);
    }

    public function editCommissionFees($id, $scope) {
        $id = decrypt($id);
        $categoryData = $this->category->getCategoryData($id)->toArray();
        return view('admin.commissionfees.edit', compact('categoryData', 'scope'));
    }

    public function updateCommissionFees(Request $request, $id, $scope) {
        $id = decrypt($id);

        if ($scope == 'Products') {
            $this->validate($request, [
                'commission' => 'required|numeric',
                'buy_it_now_fees' => 'required|numeric',
                'make_an_offer_fees' => 'required|numeric',
                'auction_fees' => 'required|numeric',
                'set_preview_fees' => 'required|numeric',
                'seller_preview_charges' => 'required|numeric',
                'buyer_preview_charges' => 'required|numeric',
            ]);
        } else if ($scope == 'Services') {
            $this->validate($request, [
                'listing_fees' => 'required|numeric',
            ]);
        }
        
        try {
            $this->category->updateCommissionFees($request, $id);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'messages' => ['global_form_message' => trans('message.failure')]]);
        }

        //\Flash::success(trans('message.commissionfees.update_success'));
        //return response()->json(['status' => 'success', 'redirectUrl' => route('commissionFeesList', $scope)]);
        return response()->json(['status' => 'success', 'message' => trans('message.commissionfees.update_success')]);
    }
    
    public function getdynamicchildajax(Request $request)
    {
        $dropdown = '';
        $input = $request->all();        
        $all_children = $this->category->getChildNameid($input['cat_id']);
        if(count($all_children) > 0)
        {            
            $dropdown .= '<div class="form-group parent_div" >'                
                    . '<label class="col-sm-4 control-label" for="cat_id[]">'.trans('message.advertisements.select_subcat').'</label>'
                    . '<div class="col-sm-4">';
            $dropdown .= '<select name="cat_id[]" class="form-control parent"><option value="0">-- Sub Category --</option>';
            foreach($all_children as $k=>$rows)
            {
                $dropdown .= '<option value="'. $rows['id'].'">'. $rows['text'].'</option>';
            }
            $dropdown .= '</select>';
            $dropdown .= '</div></div>';
            echo $dropdown;
        }
        exit;
    }    
}
