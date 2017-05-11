<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\ProductConditionRequest;
use App\Http\Controllers\Controller;
use App\Models\ProductConditions;
use App\Models\Category;
use App\Models\Product;

class ProductConditionsController extends Controller {

    public $conditions;
    public $category;

    public function __construct() {
        $this->category = new Category();
        $this->productConditions = new ProductConditions();
        $this->products = new Product();        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $productConditions = $this->productConditions->getProductConditions(true);
        return view('admin.product_conditions.index', compact('productConditions'));
    }

    /**
     * Show the form for creating a Occasions.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $categories = $this->category->getNestedData();
        unset($categories[0]);
        //return view('admin.products.create', compact('categories'));
        return view('admin.product_conditions.create', compact('categories'));
    }

    /**
     * Store a newly created occasion in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductConditionRequest $request) {
        try {            
            if ($request->ajax()) {                
                if ($this->productConditions->saveProductCondition($request)) {
                    \Flash::success(trans('message.product_conditions.add_success'));
                    return response()->json([
                                'status' => 'success',
                                'redirectUrl' => route(config('project.admin_route') . 'product_conditions.index'),
                    ]);
                } else {
                    \Flash::success(trans('message.failure'));
                    return response()->json([
                                'status' => 'error',
                                'redirectUrl' => route(config('project.admin_route') . 'product_conditions.index'),
                    ]);
                }
            } else {
                return redirect()->route(config('project.admin_route') . 'product_conditions.index');
            }
        } catch (\Exception $e) {
            \Flash::success(trans('message.failure'));
            return response()->json([
                        'status' => 'error',
                        'redirectUrl' => route(config('project.admin_route') . 'product_conditions.index'),
            ]);
        }
    }
    /**
     * Show the form for editing the Occasion.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {       
        $categories = $this->category->getNestedData();
        unset($categories[0]);        
        $productConditions = $this->productConditions->getProductConditions(false, decrypt($id));                
        return view('admin.product_conditions.edit', compact('productConditions','categories'));
    }
    /**
     * Update the specified occasion in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductConditionRequest $request, $id) {
        try {                               
            if ($request->ajax()) {
                if ($this->productConditions->saveProductCondition($request,decrypt($id))) {
                    \Flash::success(trans('message.product_conditions.update_success'));
                    return response()->json([
                                'status' => 'success',
                                'redirectUrl' => route(config('project.admin_route') . 'product_conditions.index'),
                    ]);
                } else {
                    \Flash::success(trans('message.failure'));
                    return response()->json([
                                'status' => 'error',
                                'redirectUrl' => route(config('project.admin_route') . 'product_conditions.index'),
                    ]);
                }
            } else {
                return redirect()->route(config('project.admin_route') . 'product_conditions.index');
            }
        } catch (\Exception $e) {
            
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        try {           
            $id=decrypt($id);
            $productCounts=$this->products->getProductByProductConditionId($id);
            if($productCounts>0){
                return response()->json([
                            'status' => 'error',
                            'msg' => trans('message.product_conditions.in_use')
                ]);
            }
            else{
                    if ($this->productConditions->deleteProductCondition($id)) {
                        \Flash::success(trans('message.product_conditions.delete_success'));
                        return response()->json([
                                    'status' => 'success',
                                    'msg' => trans('message.product_conditions.delete_success')
                        ]);
                    } else {
                        \Flash::success(trans('message.failure'));
                        return response()->json([
                                    'status' => 'error',
                                    'msg' => trans('message.failure')
                        ]);
                    }
            }
        } catch (\Exception $e) {            
            return trans('message.failure');
        }
    }

}
