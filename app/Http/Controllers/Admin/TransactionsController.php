<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Vendors;
use App\Models\Transactions;
use App\Models\AdminUser;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Datatables;
use DB;

class TransactionsController extends Controller {
    
    public $Vendors;
    public $Transactions;
    

    public function __construct() {
        $this->Vendors = new Vendors();
        $this->Transactions = new Transactions();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $page_title = "{trans('form.vendors.forum_title')}";
        $page_description = 'Listing of all Vendors';
        $vendor_types['all_vendor_types']=$this->VendorTypes->getVendorTypesnames();
        
        return view('admin.vendors.index', compact('page_title', 'page_description','vendor_types'));
    }

    public function datatableList(Request $request) {        
        $data = $request->only('vendor_id','filter_from','filter_to');
        
        $transactions=$this->Transactions->where('vendors_id',$data['vendor_id'])->select('*')->with('transaction_vendors')->orderBy('created_at','desc');
        
        if( isset($data['filter_from']) && !empty($data['filter_from']) ){
            $transactions->where('transaction_date','>=',$data['filter_from']);
        }
        
        if( isset($data['filter_to']) && !empty($data['filter_to']) ){            
            $transactions->where('transaction_date','<=',$data['filter_to']);
        }
        
        //$transactions=$this->Transactions->getTransactions($data['vendor_id']);
        return Datatables::of($transactions)
                        ->addColumn('action', function ($transaction) {
                            return '<a href="' . route(config('project.admin_route').'vendors.edit', encrypt($transaction->id)) . '" class="" data-toggle="tooltip" data-placement="top" title="Edit">View</i></a>' .
                                    '&nbsp;&nbsp;<a href="javascript:void(0)" class="deleteCategory" data-toggle="modal" data-placement="top" title="Delete" data-category_delete_remote="' . route(config('project.admin_route').'vendors.destroy', encrypt($transaction->id)) . '">Unpublished</a>';
                        })
                        ->addColumn('transaction_date', function ($transaction) {
                            return ($transaction->transaction_date!='0000-00-00')?$transaction->transaction_date:'';                                
                        })
                        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id) {
        $vendors['all_vendor_by_types']=$this->Vendors->getVendorbyTypes($id);
        return view('admin.transactions.create', compact('vendors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\TransationRequest $request) {
        $data = $request->only('transaction_id', 'vendors_id', 'amount_received', 'amount_paid', 'transaction_date');   
        $transections=$this->Transactions->saveTransactions($data);        
        \Flash::success(trans('message.transactions.add_success'));
        if ($request->ajax()) {
            return response()->json([
                        'status' => 'success',
                        'redirectUrl' => route(config('project.admin_route').'vendors.index'),
            ]);
        } else {
            return redirect()->route(config('project.admin_route').'vendors.index');
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
        $vendor_types['all_vendor_types']=$this->VendorTypes->getVendorTypesnames();
        $all_vendors=$this->Vendors->getVendors();
        $vendors=$this->Vendors->getVendors($id);     
        $input['countries'] = $this->Country->pluck('country_name', 'id')->all();
        $input['states'] = array();
        $input['cities'] = array();
        return view('admin.vendors.edit', compact('vendors', 'all_vendors','vendor_types', 'input'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(vendorsRequest $request, $id) {        
        $id = decrypt($id);
        $vendors=$this->Vendors->getVendors($id);        
        $data = $request->only('vendor_name', 'vendor_types_id', 'country_id', 'state_id', 'city_id', 'address_line1', 'address_line2', 'contact_number', 'contact_email', 'account_number');   

        $vendors=$this->Vendors->saveVendors($data,$id); 

        \Flash::success(trans('message.vendors.update_success'));

        if ($request->ajax()) {
            return response()->json([
                        'status' => 'success',
                        'redirectUrl' => route(config('project.admin_route').'vendors.index'),
            ]);
        } else {
            return redirect()->route(config('project.admin_route').'vendors.index');
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
            $forums=$this->Vendors->getVendors($id);
            $this->Forums->deleteVendors($id);
            if ($request->ajax()) {
                return response(['msg' => trans('message.vendors.delete_success'), 'success' => 1]);
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            return response(['msg' => $ex->errorInfo, 'success' => 0]);//$ex->getMessage()
        }
        
    }

}
