<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\donationVendorsRequest;
use App\Http\Controllers\Controller;
use App\Models\DonationVendors;
//use App\DataTables\CategoriesDataTable;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Datatables;
use DB;
use Carbon\Carbon;
class DonationVendorsController extends Controller {
    
    public $DonationVendors;

    public function __construct() {
        $this->DonationVendors = new DonationVendors();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $page_title = "{trans('form.donation_vendors.vendor_title')}";
        $page_description = 'Listing of all Vendors';
        return view('admin.donation_vendors.index', compact('page_title', 'page_description'));
    }

    public function datatableList(Request $request) {
        if ($request->has('fromDate') && $request->has('toDate') && $request->get('fromDate') != "" && $request->get('toDate') != "") {
            $arrStart = explode("-", $request->get('fromDate'));
            $arrEnd = explode("-", $request->get('toDate'));
            $fromDate = Carbon::create($arrStart[0], $arrStart[1], $arrStart[2], 0, 0, 0);
            $toDate = Carbon::create($arrEnd[0], $arrEnd[1], $arrEnd[2], 23, 59, 59);
            $donationvendors=$this->DonationVendors->getDonationVendors('',$fromDate,$toDate);
        }else{    
            $donationvendors=$this->DonationVendors->getDonationVendors();
        }
//        $departments = DB::table('topic_departments')
//                ->select([ 'topic_departments.id', 'topic_departments.department_name', 'topic_departments.department_description','topic_departments.topics','topic_departments.created_at','topic_departments.updated_at']);
        return Datatables::of($donationvendors)
                        ->addColumn('action', function ($donationvendor) {
                            return '<a href="' . route(config('project.admin_route').'donationvendors.edit', encrypt($donationvendor->id)) . '" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>' .
                                    '&nbsp;&nbsp;<a href="javascript:void(0)" class="btn btn-danger btn-xs fa fa-trash-o deleteCategory" data-toggle="modal" data-placement="top" title="Delete" data-category_delete_remote="' . route(config('project.admin_route').'donationvendors.destroy', encrypt($donationvendor->id)) . '"></a>';
                        })
                        ->addColumn('vendor_name', function ($donationvendor) {                            
                            return '<a href="' . route(config('project.admin_route').'donationvendors.edit', encrypt($donationvendor->id)) . '"  data-toggle="tooltip" data-placement="top" title="Edit">'.$donationvendor->vendor_name.'</a>';
                        })
                        ->editColumn('vendor_description', '{!! str_limit($vendor_description, 40) !!}')
                        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admin.donation_vendors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(donationVendorsRequest $request) {

        $data = $request->only('vendor_name', 'vendor_description', 'website_link', 'admin_fees', 'start_date', 'end_date','status');

        $departments=$this->DonationVendors->savedonationVendor($data);        

        \Flash::success(trans('message.donation_vendors.add_success'));
        if ($request->ajax()) {
            return response()->json([
                        'status' => 'success',
                        'redirectUrl' => route(config('project.admin_route').'donationvendors.index'),
            ]);
        } else {
            return redirect()->route(config('project.admin_route').'donationvendors.index');
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
        $all_vendors=$this->DonationVendors->getDonationVendors();
        $vendors=$this->DonationVendors->getDonationVendors($id);        
        return view('admin.donation_vendors.edit', compact('vendors', 'all_vendors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(donationVendorsRequest $request, $id) {
        $id = decrypt($id);
         
        $data = $request->only('vendor_name', 'vendor_description', 'website_link', 'admin_fees', 'start_date', 'end_date','status');
        $departments=$this->DonationVendors->savedonationVendor($data,$id);   
        
        \Flash::success(trans('message.donation_vendors.update_success'));

        if ($request->ajax()) {
            return response()->json([
                        'status' => 'success',
                        'redirectUrl' => route(config('project.admin_route').'donationvendors.index'),
            ]);
        } else {
            return redirect()->route(config('project.admin_route').'donationvendors.index');
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
            $this->DonationVendors->deleteVendors($id);
            if ($request->ajax()) {
                return response(['msg' => trans('message.donation_vendors.delete_success'), 'success' => 1]);
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            return response(['msg' => $ex->errorInfo, 'success' => 0]);//$ex->getMessage()
        }
        
    }

}
