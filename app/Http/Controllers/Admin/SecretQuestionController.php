<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\SecretQuestion;
use Datatables;
use DB;

class SecretQuestionController extends Controller {

    public $objSecretQuestion;

    public function __construct() {
        $this->objSecretQuestion = new SecretQuestion();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        return view('admin.secret_question.index');
    }

    /**
     * Display a listing of the resource - datatable list.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatableList(Request $request) {
        $secretQuestions = SecretQuestion::select('*');

        $hasPermission['delete'] = (checkAuthorize('secret_questions','delete_access')) ? TRUE : FALSE;
        
        return Datatables::of($secretQuestions)
                        ->addColumn('action', function ($secretQuestion) use ($hasPermission) {
                            $action = '';
                            $action .= ($hasPermission['delete'] && $secretQuestion->status == "Active") ? '<a href="javascript:void(0)" class="btn btn-danger btn-xs fa fa-trash-o deleteSQ" data-toggle="modal" data-placement="top" title="Delete" data-secretquestion_delete_remote="' . route(config('project.admin_route') . 'secret_questions.destroy', encrypt($secretQuestion->id)) . '"></a>' : '-';
                            return $action;
                        })
                        ->editColumn('deleted_at', function ($secretQuestion) {
                            return ($secretQuestion->deleted_at != "") ? $secretQuestion->deleted_at : "-";
                        })
                        ->make(true);
    }

    /**
     * Show the form for creating a secret question.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admin.secret_question.create');
    }

    public function store(Request $request) {
        $this->validate($request, [
            'secret_question' => 'required|max:255|unique:secret_questions',
        ]);

        try {
            $this->objSecretQuestion->createSecretQuestion($request);
        } catch (\Exception $e) {
            \Flash::error(trans('message.failure'));
            return redirect()->route(config('project.admin_route') . 'secret_questions.index');
            //return response()->json(['status' => 'error', 'messages' => ['global_form_message' => trans('message.failure')]]);
        }

        \Flash::success(trans('message.secret_questions.add_success'));
        return ($request->ajax()) ?
                response()->json(['status' => 'success', 'redirectUrl' => route(config('project.admin_route') . 'secret_questions.index')]) :
                redirect()->route(config('project.admin_route') . 'secret_questions.index');
    }

    /**
     * Remove the specified resource from storage (Inactive secret question).
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request) {
        $id = decrypt($id);
        try {
            $this->objSecretQuestion->updateSecretQuestion($request, $id);
        } catch (\Exception $e) {
            return response(['msg' => $ex->errorInfo, 'success' => 0]);
        }

        return response(['msg' => trans('message.secret_questions.delete_success'), 'success' => 1]);
        //return response()->json(['status' => 'success', 'redirectUrl' => route(config('project.admin_route') . 'secret_questions.index')]);
    }

}
