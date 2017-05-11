<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Datatables;
use Carbon\Carbon;

class FileLabels extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'file_labels';

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
    protected $fillable = ['label_name','label_description', 'id','deleted_at'];
    
    public function getFilelabels($id=null){
        if(isset($id) && !empty($id)){
            return $this->where('id',$id)->select('file_labels.id', 'file_labels.label_name', 'file_labels.label_description', 'file_labels.created_at', 'file_labels.updated_at')->first();
        }
        return $this->select('file_labels.id', 'file_labels.label_name', 'file_labels.label_description','file_labels.created_at','file_labels.updated_at');
    }
    public function getFileLabelssnames($id=null){
        return $this->pluck('label_name', 'id')->all();
    }
    
    public function getLabelwithtopic($id){        
        $data=$this->select('file_labels.id', 'file_labels.label_name')                                
                ->where('file_labels.id','=',$id)
                ->get();                        
        return $data;
    }        
    public function saveLabel($data,$id=null){        
        if(isset($id) && !empty($id)){
            return $this->where('id',$id)->update($data);
        }        
        return $this->create($data);
    }
     public function deleteLabels($id) {
        if (isset($id) && !empty($id)) {             
            $labeldelete = FileLabels::findOrFail($id);
            $labeldelete->delete();
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