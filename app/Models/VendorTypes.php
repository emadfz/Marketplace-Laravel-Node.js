<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Datatables;
use Carbon\Carbon;

class VendorTypes extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'vendor_types';

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
    protected $fillable = ['vendor_type_name','	vendor_type_description', 'id','deleted_at'];
    
    public function getEmployeeDepartments($id=null){
        if(isset($id) && !empty($id)){
            return $this->where('id',$id)->select('topic_departments.id', 'topic_departments.department_name', 'topic_departments.department_description','topic_departments.topics','topic_departments.created_at','topic_departments.updated_at')->first();
        }
        return $this->select('topic_departments.id', 'topic_departments.department_name', 'topic_departments.department_description','topic_departments.topics','topic_departments.created_at','topic_departments.updated_at');
    }
    public function getVendorTypesnames($id=null){
        return $this->pluck('vendor_type_name', 'id')->all();
    }
    
    public function getDepartmentwithtopic($id){        
        $data=$this->select('topic_departments.id', 'topic_departments.department_name')                                
                ->where('topic_departments.id','=',$id)
                ->get();                        
        return $data;
    }        
    public function saveDepartment($data,$id=null){        
        if(isset($id) && !empty($id)){
            return $this->where('id',$id)->update($data);
        }        
        return $this->create($data);
    }
     public function deleteDepartments($id) {
        if (isset($id) && !empty($id)) {             
            //return $this->softDeletes()->where('id',$id);
            

            
            $orderDetail = EmployeeDepartments::findOrFail($id);
            $orderDetail->delete();
            
            
            //$id1 = EmployeeDepartments::find( $id ); 
            //return $id1->softDeletes();
        }
        return trans('message.failure');
    }
    public function incrementDepartmentTopic($id){
        $this->where('id', $id)->increment('topics');
    }
    public function decrementDepartmentTopic($id){
        $this->where('id', $id)->decrement('topics');
    }
}