<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use Datatables;

class EmailTemplatesController extends Controller {

    public function __construct() {
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        
        return view('admin.email_templates.index');
    }

    public function datatableList(Request $request) {
        $emailTemplates = EmailTemplate::select('*');

        $hasPermission['update'] = (checkAuthorize('email_templates', 'update_access')) ? TRUE : FALSE;
        $hasPermission['delete'] = (checkAuthorize('email_templates', 'delete_access')) ? TRUE : FALSE;

        return Datatables::of($emailTemplates)
                        ->addColumn('action', function ($emailTemplate) use ($hasPermission) {
                            $action = '';
                            $action .= ($hasPermission['update']) ? '<a href="' . route(config('project.admin_route') . 'email_templates.edit', encrypt($emailTemplate->id)) . '" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="' . trans("form.edit") . '"><i class="glyphicon glyphicon-edit"></i></a>' : '';
                            $action .= ($hasPermission['delete']) ? '&nbsp;&nbsp;<a href="javascript:void(0)" class="btn btn-danger btn-xs fa fa-trash-o deleteEmailTemplate" data-toggle="modal" data-placement="top" title="' . trans("form.delete") . '" data-email_template_delete_remote="' . route(config('project.admin_route') . 'email_templates.destroy', encrypt($emailTemplate->id)) . '"></a>' : '';
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
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        
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
        $templateData = EmailTemplate::getTemplate(['id' => $id]);

        if (empty($templateData)) {
            return redirect()->route(config('project.admin_route') . 'email_templates.index');
        }

        return view('admin.email_templates.edit', compact('status', 'templateData'));
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
            'template_title' => 'required|max:255',
            'email_subject' => 'required|max:255',
            'email_content' => 'required',
            'notification_content' => 'required|max:255',
            'sms_content' => 'required|max:255',
        ]);

        try {
            EmailTemplate::updateTemplate($request, $id);
            $status = 'success';
            \Flash::success(trans('message.email_templates.update_success'));
        } catch (\Exception $e) {
            $status = 'error';
            \Flash::error(trans('message.failure'));
        }

        return response()->json(['status' => $status, 'redirectUrl' => route(config('project.admin_route') . 'email_templates.index')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request) {
        
    }

}
