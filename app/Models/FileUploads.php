<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Datatables;
use Carbon\Carbon;

class FileUploads extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'file_uploads';

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
    protected $fillable = ['file_labels_id', 'category_id', 'file_name', 'is_deleted', 'status', 'updated_at', 'created_at', 'id'];
    
    public function Files()
    {
      return $this->morphMany('App\Models\Files', 'imageable');
    }
    public function file_labels(){                        
         return $this->belongsTo('App\Models\FileLabels','file_labels_id')->withTrashed();
    }
    
    public function categories(){                
         return $this->belongsTo('App\Models\Category','category_id');
    }
    
    public function getFileUploads($id=null,$datatable=false){
        if ($datatable == true) {            
            $data=$this->where('id',$id)->select('*')->with('file_labels','categories','Files')->first();            
            foreach ($data as $key => $val) {                                
                if(isset($data[$key]->image) && !empty($data[$key]->image)){
                    $data[$key]->image=getImageByPath($val->Files->path,'documents');
                }
                else{
                    $data[$key]->image='';
                }
            }    
            return getAuthorizedButton($data)->toJson();            
        }
        else if(isset($id) && !empty($id)){                        
            return $this->where('id',$id)->select('*')->with('file_labels','categories')->first();
        }
            return $this->select('file_uploads.*')->with('file_labels','categories');
    }
    
    public function saveFileUploads($data,$id=null){        
       
        $image=@$data['image'];
        
        unset($data['image']);
        if(isset($id) && !empty($id)){
            $fileUpload= $this->where('id',$id)->first();
            $fileUpload->update($data);
            if(isset($image) && !empty($image)){
                return $fileUpload->Files()->update($image);
            }
            return $fileUpload;
            
        }
       
        return $this->create($data)->Files()->create($image);         
    }
    
    public function deletefileupload($id) {
        if (isset($id) && !empty($id)) {             
            $filedelete = FileUploads::findOrFail($id);
            $filedelete->delete();
        }
        return trans('message.failure');
    }
}