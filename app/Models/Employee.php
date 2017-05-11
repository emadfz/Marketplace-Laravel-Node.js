<?php

namespace App\Models;

use Datatables;
use Carbon\Carbon;
use DB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    protected $table = 'admin_users';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['id','employee_code','first_name', 'last_name','gender','designation','personal_email',
        'professional_email','contact_number','dob','password','department_id','type_of_hire','wages',
        'photo_relative_path','service_location','role_id','date_of_hire','confirmation_code','status','confirmed',
        'updated_at','created_at','deleted_at'];
            
    public function getEmployee()
    {
        if(\Auth::guard('admin')->user()->role_id == config('project.SUPERADMIN_ROLE_ID'))
        {
            $res = $this->select([ 'admin_users.id','admin_users.employee_code',   
                    'first_name','last_name','u_level.level_name',
                    DB::raw('concat(first_name," ",last_name) AS name'),
                    'admin_users.gender',  
                    'admin_users.status',
                    'admin_users.confirmed',
                    DB::raw('case admin_users.type_of_hire when "0" then "" 
                        when "fulltime" then "Full Time" 
                        when "parttime" then "Part Time" 
                        when "contractual" then "Contractual" end as type_of_hire'),
                    'job.job_location_name as service_location',
                    'admin_users.contact_number' ])
                ->leftJoin('employee_levels AS u_level', 'u_level.id', '=', 'admin_users.role_id')
                ->leftJoin('job_location AS job', 'job.id', '=', 'admin_users.service_location')
                ->whereNull('admin_users.deleted_at');        
        }
        else
        {
            $res = $this->select([ 'admin_users.id','admin_users.employee_code',   
                    'first_name','last_name',
                    DB::raw('concat(first_name," ",last_name) AS name'),
                    'admin_users.gender',  
                    'admin_users.confirmed',
                    DB::raw('case admin_users.type_of_hire when "0" then "" 
                        when "fulltime" then "Full Time" 
                        when "parttime" then "Part Time" 
                        when "contractual" then "Contractual" end as type_of_hire'),
                    'job.job_location_name as service_location',
                    'admin_users.contact_number' ])
                ->leftJoin('employee_levels AS u_level', 'u_level.id', '=', 'admin_users.role_id')
                ->leftJoin('job_location AS job', 'job.id', '=', 'admin_users.service_location')
                ->where([['u_level.level_name','!=', 'Superadmin' ]])
                ->whereNull('admin_users.deleted_at');
        }
         
        return $res;
    }
    
    public function employeeToEdit($id)
    {
       $res =  $this
                ->select([ 'admin_users.id', 'admin_users.employee_code','admin_users.first_name','admin_users.last_name'
                    ,'admin_users.gender'
                    ,'admin_users.designation','admin_users.personal_email'
                    ,'admin_users.professional_email'
                    ,'admin_users.contact_number'
                    , DB::raw('CASE WHEN admin_users.dob != "" and admin_users.dob != "0000-00-00" then DATE_FORMAT(dob,"%d-%m-%Y") else "" END AS dob')
                    ,'admin_users.password','admin_users.department_id','admin_users.photo_relative_path'
                    ,'admin_users.role_id'
                    ,'admin_users.type_of_hire','admin_users.service_location'
                    ,'admin_users.wages','admin_users.status'
                    , DB::raw('CASE WHEN admin_users.date_of_hire != "" and admin_users.date_of_hire != "0000-00-00" then DATE_FORMAT(admin_users.date_of_hire,"%d-%m-%Y") else "" end AS date_of_hire')
                    ,'admin_users.photo_relative_path'
                    ,'u_det.admin_user_id','u_det.address_line1','u_det.address_line2','u_det.city_id'
                    ,'u_det.state_id','u_det.country_id','u_det.zipcode'
                    , DB::raw('CASE WHEN u_det.working_hours_from != "" and u_det.working_hours_from != "00:00:00" THEN DATE_FORMAT(u_det.working_hours_from,"%h:%i %p") else "" END AS working_hours_from')
                    , DB::raw('CASE WHEN u_det.working_hours_to != "" and u_det.working_hours_to != "00:00:00" THEN DATE_FORMAT(u_det.working_hours_to,"%h:%i %p") else "" END AS working_hours_to')
                    ,'u_det.days_of_week'
                    ,'u_det.deductibles'
                    , DB::raw('CASE WHEN u_det.contract_start_date != "" and u_det.contract_start_date != "0000-00-00" then DATE_FORMAT(u_det.contract_start_date,"%d-%m-%Y") else "" end AS contract_start_date')
                    , DB::raw('CASE WHEN u_det.contract_end_date != "" and u_det.contract_end_date != "0000-00-00" then DATE_FORMAT(u_det.contract_end_date,"%d-%m-%Y") else "" end AS contract_end_date')                    
                    ,'u_det.secret_question_id'
                    ,'u_det.secret_answer'                    
                    ])
                ->leftJoin('admin_user_details AS u_det', 'u_det.admin_user_id', '=', 'admin_users.id')
                ->where([['admin_users.id','=',$id ]])
                ->first();
       
       return $res;
    }
}
