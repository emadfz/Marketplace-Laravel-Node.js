<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeSet;

use Datatables;

class AttributeController extends Controller {

    public function __construct() {
        $this->Attributeobj = new Attribute();
        $this->AttributeSetobj = new AttributeSet();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
       
        $attribute = Attribute::paginate(15);
        
        return view('admin.attribute.index', compact($attribute ));
    }

    public function datatableList(Request $request) {
        
       $attribute = $this->Attributeobj->datatablelist();
       
       return Datatables::of($attribute)
                        ->addColumn('action', function ($attri) {
                            return '<a href="' . route(config('project.admin_route').'attribute.edit', encrypt($attri->id)) . '" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>' .
                                    '&nbsp;&nbsp;<a href="javascript:void(0)" class="btn btn-danger btn-xs fa fa-trash-o deleteAttribute" data-toggle="modal" data-placement="top" title="Delete" data-attribute_delete_remote="' . route(config('project.admin_route').'attribute.destroy', encrypt($attri->id)) . '"></a>';
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
        $input['all_Attributeset'] = $this->AttributeSetobj->pluck('attribute_set_name', 'id')->all();                                       
        return view('admin.attribute.create', compact('input'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $data = $request->only('attribute_name', 'attribute_description','attribute_set_id','catelog_input_type','view_in_filter','comparable','variation_allowed');        
        
        if($data['catelog_input_type'] == 'text'){
            $this->validate($request, [
            'attribute_name' => 'required|string|max:255|unique:attributes',
            'attribute_description' => 'required|string',   
            
            ]);
        }else{
            $this->validate($request, [
                'attribute_name' => 'required|string|max:255|unique:attributes',
                'attribute_description' => 'required|string',   
                'mytext.*' => 'required|distinct'
            ]);
        }

        //$data = $request->only('attribute_name', 'attribute_description','attribute_set_id','catelog_input_type','view_in_filter','comparable');        
        $data['attribute_slug']=  str_slug($data['attribute_name']);
        $res_attribute = $this->Attributeobj->create($data);             
        $data_values = $request->only('mytext');
             
        if($data['catelog_input_type'] == 'text'){
            $data_values['mytext'] = array();
        }
        
        $res_attri_values = $this->Attributeobj->insertattrivalues($data_values,$res_attribute['attributes']['id']);
        
        if( $res_attribute && $res_attri_values )
        {
            \Flash::success(trans('attribute.add_success'));
            if ($request->ajax()) {
                return response()->json([
                            'status' => 'success',
                            'redirectUrl' => route(config('project.admin_route').'attribute.index'),
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
        
        $input['all_Attributeset'] = $this->AttributeSetobj->pluck('attribute_set_name', 'id')->all();
        $input['all_res'] = $this->Attributeobj->pluck('attribute_name', 'attribute_set_id','attribute_description','id')->all();
        $input['attribute'] = $this->Attributeobj->findOrFail($id);        
        $input['attribute_values'] = $this->Attributeobj->getvalues($id);
        return view('admin.attribute.edit', compact('input'));
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
        $result = Attribute::findOrFail($id);
        
        $data = $request->only('attribute_name', 'attribute_description','attribute_set_id','catelog_input_type','view_in_filter','comparable','variation_allowed');
        
        if($data['catelog_input_type'] == 'text'){
            $this->validate($request, [
            'attribute_name' => 'required|string|max:255|unique:attributes,attribute_name,' . $result->id, //Forcing A Unique Rule To Ignore A Given ID
            'attribute_description' => 'required|string',   
            
            ]);
        }else{
            $this->validate($request, [
                'attribute_name' => 'required|string|max:255|unique:attributes,attribute_name,' . $result->id, //Forcing A Unique Rule To Ignore A Given ID
                'attribute_description' => 'required|string',   
                'mytext.*' => 'required|distinct'
            ]);
        }
        
        //$data = $request->only('attribute_name', 'attribute_description','attribute_set_id','catelog_input_type','view_in_filter','comparable');
        $data['attribute_slug']=  str_slug($data['attribute_name']);
        $res_attribute = $result->update($data);
        
        $this->Attributeobj->deletevalues($id);        
        $data_values = $request->only('mytext'); 
        
        if($data['catelog_input_type'] == 'text'){
            $data_values['mytext'] = array();
        }
        
        $res_attri_values = $this->Attributeobj->insertattrivalues($data_values,$id);
        
        if( $res_attribute && $res_attri_values )
        {
            \Flash::success(trans('attribute.update_success'));

            if ($request->ajax()) {
                return response()->json([
                            'status' => 'success',
                            'redirectUrl' => route(config('project.admin_route').'attribute.index'),
                ]);
            } else {
                return redirect()->route(config('project.admin_route').'attribute.index');
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
            $data = Attribute::findOrFail($id)->delete();
            if ($request->ajax()) {
                return response(['msg' => trans('attribute.delete_success'), 'success' => 1]);
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            return response(['msg' => $ex->errorInfo, 'success' => 0]);            
        }
        
    }

}
