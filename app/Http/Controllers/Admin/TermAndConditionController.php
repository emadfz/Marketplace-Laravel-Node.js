<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Datatables;
use DB;
use Carbon\Carbon;
use App\Models\TermAndCondition;

class TermAndConditionController extends Controller {

    public $termAndCondition;
    public $status;

    public function __construct() {
        $this->termAndCondition = new TermAndCondition();
        $this->status = ['' => trans("form.select_status"), 'Published' => 'Published', 'Draft' => 'Draft'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $page_title = 'Manage Terms And Conditions';
        $page_description = 'Terms And Conditions';
        return view('admin.term_condition.index', compact('page_title', 'page_description'));
    }

    public function datatableList(Request $request) {
        $termsAndConditions = TermAndCondition::select('term_and_conditions.id', 'term_and_conditions.topic_name', 'term_and_conditions.status', 'term_and_conditions.created_at', 'term_and_conditions.updated_at');

        $hasPermission['update'] = (checkAuthorize('terms_and_conditions','update_access')) ? TRUE : FALSE;
        $hasPermission['delete'] = (checkAuthorize('terms_and_conditions','delete_access')) ? TRUE : FALSE;
        
        return Datatables::of($termsAndConditions)
                        ->addColumn('action', function ($termsAndCondition)  use ($hasPermission){
                            $action = '';
                            $action .= ($hasPermission['update']) ? '<a href="' . route(config('project.admin_route') . 'terms_and_conditions.edit', encrypt($termsAndCondition->id)) . '" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>' : '';
                            $action .= ($hasPermission['delete']) ? '&nbsp;&nbsp;<a href="javascript:void(0)" class="btn btn-danger btn-xs fa fa-trash-o deleteTC" data-toggle="modal" data-placement="top" title="Delete" data-termcondition_delete_remote="' . route(config('project.admin_route') . 'terms_and_conditions.destroy', encrypt($termsAndCondition->id)) . '"></a>' : '';
                            return $action;
                        })
                        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $status = $this->status;
        return view('admin.term_condition.create', compact('status'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'topic_name' => 'required|max:255|unique:term_and_conditions',
            'terms_conditions' => 'required',
            'meta_title' => 'max:50',
            'meta_keywords' => 'max:200',
            'meta_description' => 'max:160',
            'status' => 'required',
        ]);
 
        try {
            $this->termAndCondition->createTermCondition($request);
        } catch (\Exception $e) {
            \Flash::error(trans('message.failure'));
            return redirect()->route(config('project.admin_route') . 'terms_and_conditions.index');
            //return response()->json(['status' => 'error', 'messages' => ['global_form_message' => trans('message.failure')]]);
        }

        \Flash::success(trans('message.term_condition.add_success'));
        return ($request->ajax()) ?
                response()->json(['status' => 'success', 'redirectUrl' => route(config('project.admin_route') . 'terms_and_conditions.index')]) :
                redirect()->route(config('project.admin_route') . 'terms_and_conditions.index');
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
        $status = $this->status;
        
        $termAndConditionData = $this->termAndCondition->getTermCondition($id);
        
        if(empty($termAndConditionData)){
            return redirect()->route(config('project.admin_route') . 'terms_and_conditions.index');
        }
        
        return view('admin.term_condition.edit', compact('status','termAndConditionData'));
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
        
        $this->validate($request, [
            'topic_name' => 'required|max:255|unique:term_and_conditions,topic_name,'. $id,
            'terms_conditions' => 'required',
            'meta_title' => 'max:50',
            'meta_keywords' => 'max:200',
            'meta_description' => 'max:160',
            'status' => 'required',
        ]);
        
        $requestFields = $request->except(['_method', '_token']);
        
        try {
            $this->termAndCondition->updateTermCondition($requestFields, $id);
        } catch (\Exception $e) {
            \Flash::error(trans('message.failure'));
            return redirect()->route(config('project.admin_route') . 'terms_and_conditions.index');
            //return response()->json(['status' => 'error', 'messages' => ['global_form_message' => trans('message.failure')]]);
        }

        \Flash::success(trans('message.term_condition.update_success'));
        return ($request->ajax()) ?
                response()->json(['status' => 'success', 'redirectUrl' => route(config('project.admin_route') . 'terms_and_conditions.index')]) :
                redirect()->route(config('project.admin_route') . 'terms_and_conditions.index');
        
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
            $data = TermAndCondition::findOrFail($id)->delete();
            if ($request->ajax()) {
                return response(['msg' => trans('message.term_condition.delete_success'), 'success' => 1]);
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            return response(['msg' => $ex->errorInfo, 'success' => 0]); //$ex->getMessage()
            //return response(['msg' => trans('message.failure'), 'success' => 0]);
        }
    }

}
