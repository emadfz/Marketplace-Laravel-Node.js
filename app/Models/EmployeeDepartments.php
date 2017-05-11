<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Datatables;
use Carbon\Carbon;

class EmployeeDepartments extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'topic_departments';

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
    protected $fillable = ['department_name','department_description','color', 'id','deleted_at'];
    
    public function getEmployeeDepartments($id=null){
        if(isset($id) && !empty($id)){
            return $this->where('id',$id)->select('topic_departments.id', 'topic_departments.department_name', 'topic_departments.department_description','topic_departments.topics','topic_departments.created_at','topic_departments.updated_at','topic_departments.color')->first();
        }
        return $this->select('topic_departments.id', 'topic_departments.department_name', 'topic_departments.department_description','topic_departments.topics','topic_departments.created_at','topic_departments.updated_at','topic_departments.color');
    }
    public function getEmployeeDepartmentsnames($id=null){
        return $this->pluck('department_name', 'id')->all();
    }
    
    public function getDepartmentwithtopic($id){        
        $data=$this->select('topic_departments.id', 'topic_departments.department_name')                                
                ->where('topic_departments.id','=',$id)
                ->get();                        
        return $data;
    }

    public function Files()
    {
        return $this->morphMany('App\Models\Files', 'imageable');
    }

    public function saveDepartment($data,$id=null,$image=''){

        if(isset($id) && !empty($id)){
            unset($data['_token']);
            unset($data['_method']);
            unset($data['code']);
            $department=$this->where('id', $id)->first();
            $department->update($data);
            if(isset($image) && !empty($image)){
                $department->Files()->update($image);
            }
            //return $this->where('id',$id)->update($data);
            return $department;
        }

        $department=$this->create($data);
        if(isset($image) && !empty($image)){
            $department->Files()->create($image);
        }
        return $department;
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