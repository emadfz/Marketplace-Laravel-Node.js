<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Datatables;
use DB;
use Carbon\Carbon;

class NewsletterController extends Controller {

    public $objNewsletter;
    public $status;

    public function __construct() {
        $this->objNewsletter = new Newsletter();
        $this->status = ['' => trans("form.select_status"), 'Draft' => 'Draft', 'Active' => 'Active'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        return view('admin.newsletter.index');
    }

    /**
     * Display a listing of the resource - datatable list.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatableList(Request $request) {

        /*if ($request->get('fromDate') != "" && $request->get('toDate') != "") {

            $arrStart = explode("-", $request->get('fromDate'));
            $arrEnd = explode("-", $request->get('toDate'));
            $fromDate = Carbon::create($arrStart[0], $arrStart[1], $arrStart[2], 0, 0, 0);
            $toDate = Carbon::create($arrEnd[0], $arrEnd[1], $arrEnd[2], 23, 59, 59);
            $newsletters = DB::table('newsletters')->select('*')->whereBetween('newsletter_date', [$fromDate, $toDate]);
        } else {
            $newsletters = DB::table('newsletters')->select('*');
        }*/
        $newsletters = Newsletter::select('*');
        
        $hasPermission['update'] = (checkAuthorize('newsletters','update_access')) ? TRUE : FALSE;
        $hasPermission['delete'] = (checkAuthorize('newsletters','delete_access')) ? TRUE : FALSE;
        
        return Datatables::of($newsletters)
                        ->addColumn('action', function ($newsletter) use ($hasPermission){
                            //$resendLink = ($newsletter->status == "Sent") ? '&nbsp;&nbsp;<a href="' . route('adminResendNewsletter', encrypt($newsletter->id)) . '" class="btn btn-default btn-xs fa fa-clone" title="'.trans("form.newsletters.resend_newsletter").'"></a>' : '';
                            $action = '';
                            $action .= ($hasPermission['update']) ? '<a href="' . route(config('project.admin_route') . 'newsletters.edit', encrypt($newsletter->id)) . '" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="' . trans("form.edit") . '"><i class="glyphicon glyphicon-edit"></i></a>' : '';
                            $action .= ($hasPermission['delete'] && $newsletter->status != "Sent") ? '&nbsp;&nbsp;<a href="javascript:void(0)" class="btn btn-danger btn-xs fa fa-trash-o deleteNewsletter" data-toggle="modal" data-placement="top" title="' . trans("form.delete") . '" data-newsletter_delete_remote="' . route(config('project.admin_route') . 'newsletters.destroy', encrypt($newsletter->id)) . '"></a>' : '';
                            $action .= ($hasPermission['update'] && $newsletter->status == "Sent") ? '&nbsp;&nbsp;<a href="' . route(config('project.admin_route') . 'newsletters.edit', [encrypt($newsletter->id), 'resend' => 1]) . '" class="btn btn-default btn-xs fa fa-clone" title="' . trans("form.newsletters.resend_newsletter") . '"></a>' : '';
                            return $action;
                        })
                        ->filter(function ($query) use ($request) {
                            if ($request->has('fromDate') && $request->has('toDate') && $request->get('fromDate') != "" && $request->get('toDate') != "") {
                                $arrStart = explode("-", $request->get('fromDate'));
                                $arrEnd = explode("-", $request->get('toDate'));
                                $fromDate = Carbon::create($arrStart[0], $arrStart[1], $arrStart[2], 0, 0, 0)->toDateTimeString();
                                $toDate = Carbon::create($arrEnd[0], $arrEnd[1], $arrEnd[2], 23, 59, 59)->toDateTimeString();
                                $bothDate['from']   = $fromDate;
                                $bothDate['to']     = $toDate;

                                $query->whereBetween('newsletter_date', [$fromDate, $toDate])->orWhere(function ($query) use ($bothDate) { $query->where('newsletter_date', '=', date('Y-m-d',strtotime($bothDate['from'])));$query->where('newsletter_date', '=', date('Y-m-d',strtotime($bothDate['to'])));
                            });
                            }
                        })
                        ->make(true);
    }

    public function resendNewsletter($id) {
        $id = decrypt($id);
        $tomorrow = Carbon::parse('tomorrow')->format("Y-m-d");

        $newsletter = $this->objNewsletter->getNewsletter($id);

        $duplicateEntry = $newsletter->replicate();
        $duplicateEntry->newsletter_date = $tomorrow;
        $duplicateEntry->status = 'Draft';
        $duplicateEntry->admin_user_id = auth()->guard('admin')->user()->id;
        $duplicateEntry->created_at = Carbon::now();
        $duplicateEntry->save();

        \Flash::success(trans('message.newsletters.resend_add_success'));
        return redirect()->route(config('project.admin_route') . 'newsletters.index');
    }

    /**
     * Show the form for creating a newsletter
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $status = $this->status;
        return view('admin.newsletter.create', compact('status'));
    }

    public function store(Request $request) {
        $this->validate($request, [
            'newsletter_title' => 'required|max:100|unique:newsletters',
            'newsletter_content' => 'required',
            'status' => 'required',
            'newsletter_date' => 'required|date',
        ]);

        try {
            $this->objNewsletter->createNewsletter($request);
        } catch (\Exception $e) {
            \Flash::error(trans('message.failure'));
            return redirect()->route(config('project.admin_route') . 'newsletters.index');
        }

        \Flash::success(trans('message.newsletters.add_success'));
        return ($request->ajax()) ?
                response()->json(['status' => 'success', 'redirectUrl' => route(config('project.admin_route') . 'newsletters.index')]) :
                redirect()->route(config('project.admin_route') . 'newsletters.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request) {
        $resend = 0;
        if ($request->has('resend')) {
            $resend = 1;
        }

        $id = decrypt($id);
        $status = $this->status;

        $newsletterData = $this->objNewsletter->getNewsletter($id);

        if (empty($newsletterData)) {
            return redirect()->route(config('project.admin_route') . 'newsletters.index');
        }

        return view('admin.newsletter.edit', compact('status', 'newsletterData', 'resend'));
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
            'newsletter_title' => 'required|max:100|unique:newsletters,newsletter_title,' . $id,
            //'newsletter_title' => 'required|max:100',
            'newsletter_content' => 'required',
            'status' => 'required',
            'newsletter_date' => 'required|date|date_format:Y-m-d|after:today',
        ]);


        if ($request->has('resend') && $request->input('resend') == 1) {
            // Resend Newsletter - on resend action to create new newsletter based on that prefilled info
            try {
                $this->objNewsletter->createNewsletter($request);
            } catch (\Exception $e) {
                \Flash::error(trans('message.failure'));
                return redirect()->route(config('project.admin_route') . 'newsletters.index');
            }

            \Flash::success(trans('message.newsletters.resend_add_success'));
        } else {
            // On edit action, newsletter will be updated
            try {
                $this->objNewsletter->updateNewsletter($request, $id);
            } catch (\Exception $e) {
                \Flash::error(trans('message.failure'));
                return redirect()->route(config('project.admin_route') . 'newsletters.index');
            }

            \Flash::success(trans('message.newsletters.update_success'));
        }

        return ($request->ajax()) ?
                response()->json(['status' => 'success', 'redirectUrl' => route(config('project.admin_route') . 'newsletters.index')]) :
                redirect()->route(config('project.admin_route') . 'newsletters.index');
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
            $data = Newsletter::findOrFail($id)->delete();
            if ($request->ajax()) {
                return response(['msg' => trans('message.newsletters.delete_success'), 'success' => 1]);
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            return response(['msg' => trans('message.failure'), 'success' => 0]); //$ex->errorInfo
            //return response(['msg' => trans('message.failure'), 'success' => 0]);
        }
    }

}
