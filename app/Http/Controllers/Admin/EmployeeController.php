<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Hash;
use Mail;

use Jrean\UserVerification\Traits\VerifiesUsers;
use Jrean\UserVerification\Facades\UserVerification;

use Datatables;
use DB;

//// All Model files 
use App\Models\Level;
use App\Models\JobLocation;
use App\Models\EmployeeDepartment;
use App\Models\Employee;
use App\Models\EmployeeDetail;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\SecretQuestion;
use App\Models\EmployeeDesignation;
use App\Http\Requests\EmployeeRequest;

class EmployeeController extends Controller
{    
    public $Employee ;
    
    public function __construct()
    {
        $this->Employee = new Employee();
        $this->EmployeeDetail = new EmployeeDetail();
        $this->Country = new Country();
        $this->State = new State();
        $this->City = new City();
        $this->Level = new Level();
        $this->EmployeeDepartment = new EmployeeDepartment();
        $this->JobLocation = new JobLocation();
        $this->SecretQuestion = new SecretQuestion();
        $this->EmployeeDesignation = new EmployeeDesignation();
    }
    
    public function index()
    {  
        //$employees = $this->Employee->getEmployee();        
        return view('admin.employee.index', compact('employee'));
    }
    
    public function datatableList(Request $request) {
        
        $employees = $this->Employee->getEmployee();        
        return Datatables::of($employees)
                        ->addColumn('action', function ($emp) {
                            $res = '<a href="' . route(config('project.admin_route').'employee.edit', encrypt($emp->id)) . '" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>' .
                                    '&nbsp;&nbsp;<a href="javascript:void(0)" class="btn btn-danger btn-xs fa fa-trash-o deleteAttribute" data-toggle="modal" data-placement="top" title="Delete" data-attribute_delete_remote="' . route(config('project.admin_route').'employee.destroy', encrypt($emp->id)) . '"></a>';
                            if( $emp->status != 'Blocked' )
                            {
                                $res .= '<a href="javascript:void(0)" class="btn btn-xs btn-primary blockattribute" data-toggle="modal" data-placement="top" title="Block" data-attribute_block_remote="' . route(config('project.admin_route').'employee.block', ['id'=>encrypt($emp->id)]) . '"><span class="glyphicon glyphicon-ban-circle"> </span></a>';
                            }     
                            else
                            {
                                $res .= '<a href="javascript:void(0)" class="btn btn-danger btn-xs fa btn-primary unblockattribute" data-toggle="modal" data-placement="top" title="Block" data-attribute_unblock_remote="' . route(config('project.admin_route').'employee.unblock', ['id'=>encrypt($emp->id)]) . '"><span class="glyphicon glyphicon-ok-circle"> </span></a>';
                            }
                            return $res;
                        })    
                        ->editColumn('first_name', function ($emp) {
                            return ($emp->first_name != "") ? '<a href="'.route(config('project.admin_route').'faq.edit', encrypt($emp->id)).'">'.$emp->first_name.'</a>' : "-";
                        })                          
                        ->editColumn('employee_code', function ($emp) {
                            return ($emp->employee_code != "") ? '<a href="'.route(config('project.admin_route').'faq.edit', encrypt($emp->id)).'">'.$emp->employee_code.'</a>' : "-";
                        })
                        ->editColumn('last_name', function ($emp) {
                            return ($emp->last_name != "") ? '<a href="'.route(config('project.admin_route').'faq.edit', encrypt($emp->id)).'">'.$emp->last_name.'</a>' : "-";
                        })                      
                        ->make(true);
    }
    
    public function create() {
        
        $date = date_create();        
        $input['employee_code'] = date_timestamp_get($date);
        $input['countries'] = $this->Country->pluck('country_name', 'id')->all();
        $input['states'] = array();
        $input['cities'] = array();
        if(\Auth::guard('admin')->user()->role_id == config('project.SUPERADMIN_ROLE_ID')){
            $input['levels'] = $this->Level->pluck('level_name', 'id')->all();
        }
        else{
            $input['levels'] = $this->Level->where('id', '!=',config('project.SUPERADMIN_ROLE_ID'))->pluck('level_name', 'id')->all();
        }
        
        $input['departments'] = $this->EmployeeDepartment->pluck('department_name', 'id')->all();
        $input['joblocation'] = $this->JobLocation->pluck('job_location_name','id')->all();
        $input['secretquestions'] = $this->SecretQuestion->whereNull('deleted_at')->pluck('secret_question','id')->all();
        $input['designations'] = $this->EmployeeDesignation->pluck('name','id')->all();
                
        return view('admin.employee.create', compact('input'));
    }
     //delete_at is null

    public function store(EmployeeRequest $request)
    {
        $name = '';
        
        if($request->hasFile('photo')) {
                        
            $file = Input::file('photo');
            //getting timestamp
            $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
            $imagetype = explode('/',$file->getClientMimeType());
            $name = $timestamp. '.' .$imagetype[count($imagetype)-1] ;
            
            $file->move(public_path().'/images/employee/', $name);            
        }
                
        $user_data = $request->only('employee_code','first_name','last_name','gender',
                'personal_email','professional_email','contact_number','designation','password',
                'department_id','dob','role_id','type_of_hire','service_location','wages','date_of_hire');
        
        $user_data['dob'] = ($user_data['dob'] != '') ? date('Y-m-d',strtotime($user_data['dob'])) : '';
        $user_data['date_of_hire'] = ( $user_data['date_of_hire'] != '') ? date('Y-m-d',strtotime($user_data['date_of_hire'])) : '';        
        $user_data['password'] = bcrypt($user_data['password']) ;        
        $user_data['confirmation_code'] = str_random(30) ;
        if($name != '')
        $user_data['photo_relative_path'] = $name;
        
        $res = $this->Employee->create($user_data);           
        
        if( !empty($res->id) )
        {
            Mail::send('admin.email.verify', ['confirmation_code' => $user_data['confirmation_code'] ], function($message){
                    $message->to(Input::get('professional_email'), Input::get('first_name').' '.Input::get('last_name'))
                            ->subject('Verify your email address');
                });
                
            $userdetails_data = $request->only('address_line1', 'address_line2','city_id','state_id','country_id','zipcode','working_hours_from','working_hours_to',
    'days_of_week','deductibles','contract_start_date','contract_end_date','secret_question_id', 'secret_answer');

            $userdetails_data['contract_start_date'] = ($userdetails_data['contract_start_date'] != '') ? date('Y-m-d',strtotime($userdetails_data['contract_start_date'])): ' ';
            $userdetails_data['contract_end_date'] = ($userdetails_data['contract_end_date'] != '') ? date('Y-m-d',strtotime($userdetails_data['contract_end_date'])) : '';        
            $userdetails_data['working_hours_from'] = ($userdetails_data['working_hours_from'] != '') ? date('H:i',strtotime($userdetails_data['working_hours_from'])):'';
            $userdetails_data['working_hours_to'] = ($userdetails_data['working_hours_to'] != '') ? date('H:i',strtotime($userdetails_data['working_hours_to'])): '';
            $userdetails_data['admin_user_id'] = $res->id;

            $this->EmployeeDetail->create($userdetails_data);

            \Flash::success(trans('employee.add_success'));
            if ($request->ajax()) {
                return response()->json([
                            'status' => 'success',
                            'redirectUrl' => route(config('project.admin_route').'employee.index'),
                ]);
            } else {
                return redirect()->route(config('project.admin_route').'employee.index');
            }                                        
        }        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function show($id)
    {        
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function edit($id)
    {        
        $input = array();
        $input['states'] = array();        
        $input['cities'] = array();
        $input['employee_code'] = NULL;
        $id = decrypt($id);
        
        $input['employee'] = $this->Employee->employeeToEdit($id);
        $input['countries'] = $this->Country->pluck('country_name', 'id')->all();  
              
        if(!empty($input['employee']->country_id))
            $input['states'] = $this->State->where('country_id', $input['employee']->country_id)->pluck('state_name','id')->toArray();                     
        
        if(!empty($input['states']))        
            $input['cities'] = $this->City->whereIn('state_id', array_keys($input['states']))->pluck('city_name','id')->toArray();        
        
        if(\Auth::guard('admin')->user()->role_id == config('project.SUPERADMIN_ROLE_ID')){
            $input['levels'] = $this->Level->pluck('level_name', 'id')->all();
        }
        else{
            $input['levels'] = $this->Level->where('id', '!=',config('project.SUPERADMIN_ROLE_ID'))->pluck('level_name', 'id')->all();
        }
        
        $input['departments'] = $this->EmployeeDepartment->pluck('department_name', 'id')->all();
        $input['action_type'] = 'edit';        
        $input['employee']->days_of_week = explode(',',$input['employee']->days_of_week);
        $input['joblocation'] = $this->JobLocation->pluck('job_location_name','id')->toArray();
        $input['secretquestions'] = $this->SecretQuestion->whereNull('deleted_at')->pluck('secret_question','id')->all();
        $input['designations'] = $this->EmployeeDesignation->pluck('name','id')->all();
        return view('admin.employee.edit', compact('input'));                
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function update($id, EmployeeRequest $request)
    {
        try{
        $name = '';
        $id = decrypt($id);
        $result = Employee::findOrFail($id);
        
        if($request->hasFile('photo')) {
            if($result->photo_relative_path != ''){
                @unlink(public_path().'/images/employee/'. $result->photo_relative_path);
            }
            
            $file = Input::file('photo');
            //getting timestamp
            $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
            $imagetype = explode('/',$file->getClientMimeType());
            $name = $timestamp. '.' .$imagetype[count($imagetype)-1] ;
            
            $file->move(public_path().'/images/employee/', $name);            
        }
        
        if($request->hasFile('documents')) {
            $document_file = Input::file('documents');
            //getting timestamp
            $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());            
            $name = $timestamp. '-' .$document_file->getClientOriginalName();            
            $document_file->move(public_path().'/documents/', $name);            
        }
        
        $data = $request->only('employee_code','first_name','last_name','gender',
                'personal_email','professional_email','contact_number','designation',
                'department_id','dob','role_id','type_of_hire','service_location','wages','date_of_hire');
        
        
        $data['dob'] = ($data['dob'] != '') ? date('Y-m-d',strtotime($data['dob'])) : '';
        $data['date_of_hire'] = ($data['date_of_hire'] != '') ? date('Y-m-d',strtotime($data['date_of_hire'])):'';
        if($name != '')
        $data['photo_relative_path'] = $name;
        
        $test = $result->update($data);
        
        $data_userdetails = $request->only('address_line1','address_line2','city_id',
                'state_id','country_id','zipcode','working_hours_from','working_hours_to',
                'days_of_week','deductibles','contract_start_date','contract_end_date',
                'secret_question_id','secret_answer');
        
        if(!empty($data_userdetails['days_of_week']))
        $data_userdetails['days_of_week'] = implode(',',$data_userdetails['days_of_week']);        
        $data_userdetails['contract_start_date'] = ($data_userdetails['contract_start_date'] != '') ? date('Y-m-d',strtotime($data_userdetails['contract_start_date'])):' ';
        $data_userdetails['contract_end_date'] = ($data_userdetails['contract_end_date'] != '') ? date('Y-m-d',strtotime($data_userdetails['contract_end_date'])):' ';
        $data_userdetails['working_hours_from'] = ($data_userdetails['working_hours_from'] != '') ? date('H:i',strtotime($data_userdetails['working_hours_from'])):'';
        $data_userdetails['working_hours_to'] = ($data_userdetails['working_hours_to'] != '') ? date('H:i',strtotime($data_userdetails['working_hours_to'])): '';
        $user_details = $this->EmployeeDetail->where('admin_user_id', $id )->get()->toArray();
        if(empty($user_details))
        {
            $data_userdetails['admin_user_id'] = $id;
            $this->EmployeeDetail->create($data_userdetails);
        }
        else
        {
            $this->EmployeeDetail->where('admin_user_id', $id )->update($data_userdetails);
        }

        $data = ['user_name' => $request->first_name];
        
       \Mail::send('admin.email.update',  $data , function ($m) use ($request)  {
            $m->from('info@inspree.com', 'Your Admin Profile has been updated');
            $m->to($request->personal_email, $request->first_name)
            ->to($request->professional_email, $request->first_name)
            ->subject('Your Admin Profile has been updated - Inspree');
        });
            // \Mail::send('admin.email.update', function($message){
            //     $message->to($request->personal_email, Input::get('first_name').' '.Input::get('last_name'))
            //         ->subject('Updates Applied to your profile');
            // }); 
        // }
        // elseif($request->professional_email != $request->professional_email)
        // {echo "2";die;
        //      Mail::send('admin.email.update', ['confirmation_code' => $user_data['confirmation_code'] ], function($message){
        //         $message->to($request->professional_email, Input::get('first_name').' '.Input::get('last_name'))
        //             ->subject('Updates Applied to your profile');
        //     });
        // }


        \Flash::success(trans('employee.update_success'));

        if ($request->ajax()) {
            return response()->json([
                        'status' => 'success',
                        'redirectUrl' => route(config('project.admin_route').'employee.index'),
            ]);
        } else {
            return redirect()->route(config('project.admin_route').'employee.index');
        }
    }catch(\Exception $e){
        // echo $e->getMessage(); die;
    }
    }
 
    //     else
    //     {
    //         $this->EmployeeDetail->where('admin_user_id', $id )->update($data_userdetails);
    //     }
        
    //     \Flash::success(trans('employee.update_success'));

    //     if ($request->ajax()) {
    //         return response()->json([
    //                     'status' => 'success',
    //                     'redirectUrl' => route(config('project.admin_route').'employee.index'),
    //         ]);
    //     } else {
    //         return redirect()->route(config('project.admin_route').'employee.index');
    //     }
    // }


    
    public function confirm($confirmation_code)
    {
        if( ! $confirmation_code)
        {
            return response(['msg' => 'Confirmation code is not available ', 'success' => 0]);
        }
                
        $user = Employee::where('confirmation_code' , '=', $confirmation_code)->first();
        
        if ( ! $user)
        {            
            return response(['msg' => 'Confirmation code is not valid Or already confirmed , Try to Login', 'success' => 0]);
        }
        
        $user->status=config('project.status_active');
        $user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();
                
        \Flash::success(trans('employee.verification_success'));
        
        return redirect()->route('adminLogin');        
    }
    
    // this function will block employee    
    public function block(Request $request)
    {     
        $res = $request->all();
        $id = decrypt($res['id']);
        $user = Employee::where('id' , '=', $id)->first();
        
        try {
            $user->status = config('project.status_blocked');        
            $user->save();
            
            if ($request->ajax()) {
                return response(['msg' => trans('employee.block_success'), 'success' => 1]);
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            return response(['msg' => $ex->errorInfo, 'success' => 0]);            
        }
        
    }
    
    // this function will unblock employee
    public function unblock(Request $request)
    {     
        $res = $request->all();
        $id = decrypt($res['id']);
        $user = Employee::where('id' , '=', $id)->first();
        
        try {
            $user->status = config('project.status_active');        
            $user->save();
            
            if ($request->ajax()) {
                return response(['msg' => trans('employee.unblock_success'), 'success' => 1]);
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            return response(['msg' => $ex->errorInfo, 'success' => 0]);            
        }
        
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function destroy($id, Request $request)
    {
        $id = decrypt($id);
        try {
            $data = Employee::find($id)->delete();                        
            EmployeeDetail::where('admin_user_id', '=', $id)->delete();
            
            if ($request->ajax()) {
                return response(['msg' => trans('employee.delete_success'), 'success' => 1]);
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            return response(['msg' => $ex->errorInfo, 'success' => 0]);            
        }
    }
    
}
