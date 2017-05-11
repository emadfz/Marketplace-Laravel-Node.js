<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\departmentsRequest;
use App\Http\Controllers\Controller;
use App\Models\EmployeeDepartments;
//use App\DataTables\CategoriesDataTable;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Datatables;
use DB;

class EmployeeDepartmentsController extends Controller {
    
    public $EmployeeDepartments;

    public function __construct() {
        $this->EmployeeDepartments = new EmployeeDepartments();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $page_title = "{trans('form.topic_departments.department_title')}";
        $page_description = 'Listing of all departments';
        return view('admin.departments.index', compact('page_title', 'page_description'));
    }

    public function datatableList(Request $request) {
        
        $departments=$this->EmployeeDepartments->getEmployeeDepartments();
        
//        $departments = DB::table('topic_departments')
//                ->select([ 'topic_departments.id', 'topic_departments.department_name', 'topic_departments.department_description','topic_departments.topics','topic_departments.created_at','topic_departments.updated_at']);
        return Datatables::of($departments)
                        ->addColumn('action', function ($department) {
                            return '<a href="' . route(config('project.admin_route').'departments.edit', encrypt($department->id)) . '" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>' .
                                    '&nbsp;&nbsp;<a href="javascript:void(0)" class="btn btn-danger btn-xs fa fa-trash-o deleteCategory" data-toggle="modal" data-placement="top" title="Delete" data-category_delete_remote="' . route(config('project.admin_route').'departments.destroy', encrypt($department->id)) . '"></a>';
                        })
                        ->editColumn('department_description', '{!! str_limit($department_description, 40) !!}')
                        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admin.departments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(departmentsRequest $request) {

        $data = $request->only('department_name', 'department_description','color');

        $image ='';
        if ($request->hasFile('image')) {
            $image = uploadImage($request->file('image'),true);
        }

        $departments=$this->EmployeeDepartments->saveDepartment($data,'',$image);

        \Flash::success(trans('message.topic_departments.add_success'));
        if ($request->ajax()) {
            return response()->json([
                        'status' => 'success',
                        'redirectUrl' => route(config('project.admin_route').'departments.index'),
            ]);
        } else {
            return redirect()->route(config('project.admin_route').'departments.index');
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
        $all_departments=$this->EmployeeDepartments->getEmployeeDepartments();
        $departments=$this->EmployeeDepartments->getEmployeeDepartments($id);
        return view('admin.departments.edit', compact('departments', 'all_departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(departmentsRequest $request, $id) {

        $data_img = $request->all();
        $image ='';
        if ($request->hasFile('image')) {

            if (isset($request->old_image) && !empty($request->old_image)) {
                $image = uploadImage($request->file('image'),true,$request->old_image);
            }
            else{
                $image = uploadImage($request->file('image'),true);
            }


        }

        unset($data_img['image']);
        unset($data_img['old_image']);

        $id = decrypt($id);
        $departments=$this->EmployeeDepartments->getEmployeeDepartments($id);        
        
        $data = $request->only('department_name', 'department_description','color');
        $departments=$this->EmployeeDepartments->saveDepartment($data,$id,$image);

        \Flash::success(trans('message.topic_departments.update_success'));

        if ($request->ajax()) {
            return response()->json([
                        'status' => 'success',
                        'redirectUrl' => route(config('project.admin_route').'departments.index'),
            ]);
        } else {
            return redirect()->route(config('project.admin_route').'departments.index');
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
        $forums=new \App\Models\Forums;
        $forums=$forums->getForums($id);
        if(count($forums)>0){
            return response()->json([
                        'status' => 'error',
                        'msg'=>'Topic(s) assigned to this Department so you can not delete'
            ]);
        }
        
        try {
            $this->EmployeeDepartments->deleteDepartments($id);
            if ($request->ajax()) {
                return response(['msg' => trans('message.topic_departments.delete_success'), 'success' => 1]);
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            return response(['msg' => $ex->errorInfo, 'success' => 0]);//$ex->getMessage()
        }
        
    }

}
