<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Datatables;
use Carbon\Carbon;

class Vendors extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'vendors';

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
    protected $fillable = ['vendor_name', 'vendor_types_id', 'contact_person', 'country_id', 'state_id', 'city_id', 'address_line1', 'zipcode', 'contact_number', 'contact_email', 'account_number', 'is_deleted', 'status', 'updated_at', 'created_at', 'id', 'skype_id'];
    
    public function employee_departments(){                        
         return $this->belongsTo('App\Models\EmployeeDepartments','topic_department_id')->withTrashed();
    }
    
    public function getVendorbyTypes($id=null){
        return $this->where(['vendor_types_id' => $id])->pluck('vendor_name', 'id')->all();
    }
    public function admin_users(){                
         return $this->belongsTo('App\Models\AdminUser');
    }
    
    public function getForums($id=null){
        if(isset($id) && !empty($id)){
            return $this->where('id',$id)->select('*')->with('employee_departments','admin_users')->first();
        }
            return $this->select('*')->with('employee_departments','admin_users')->get();
    }
    
    public function saveVendor($data,$id=null){        
        if(isset($id) && !empty($id)){
            return $this->where('id',$id)->update($data);
        }        
        return $this->create($data);
    }
     public function deleteForums($id) {
        if (isset($id) && !empty($id)) {
            return $this->where('id', $id)->delete();
        }
        return trans('message.failure');
    }
    
}