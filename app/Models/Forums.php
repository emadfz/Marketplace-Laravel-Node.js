<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Datatables;
use Carbon\Carbon;

class Forums extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'forums';

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
    protected $fillable = ['topic_name', 'topic_department_id','topic_description', 'admin_users_id', 'total_likes',' total_dislikes', 'total_comments', 'total_views', 'is_deleted', 'status', 'updated_at', 'created_at', 'id'];
    
    public function employee_departments(){                        
         //return $this->belongsTo('App\Models\EmployeeDepartments','topic_department_id')->withTrashed();
        return $this->belongsTo('App\Models\EmployeeDepartments','topic_department_id');
    }
    public function report_abuses(){
        return $this->hasMany('App\Models\ReportAbuses','ref_id','id')->where('type','=','topic');
    }
    
    public function admin_users(){                
         return $this->belongsTo('App\Models\AdminUser');
    }
    
    public function  getForums($id=null){
        if(isset($id) && !empty($id)){
            return $this->where('id',$id)->select('*')->with('employee_departments')->has('employee_departments')->first();
        }
        
            return $this->select('*')->with('employee_departments','report_abuses')->has('employee_departments');
    }

    public function saveForum($data,$id=null){
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

    public function getFiveMonthOldTopics($date){
        return $this->select('id','created_at','total_comments')->where('status', 'active')->where('created_at','<',$date)->get()->toArray();
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comments', 'forum_id', 'id');
    }
    
}