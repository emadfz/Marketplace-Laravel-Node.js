<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class occasions extends Model
{
    
    protected $fillable = [
        'name',
        'status',
        'start_date',
        'end_date',
    ];

    public function Files()
    {
      return $this->morphMany('App\Models\Files', 'imageable');
    }
    public function saveOccasions($data, $id = NULL) {                                
        
        $data['start_date']=\Carbon\Carbon::parse($data['start_date'])->format('Y-m-d');        
        $data['end_date']=\Carbon\Carbon::parse($data['end_date'])->format('Y-m-d');                
        
        if (isset($id) && !empty($id)) {                                     
            $images=array();
            if(isset($data['image']) && !empty($data['image'])){
                    $images=$data['image'];
                    unset($data['image']);
            }
            
            $occasions=$this->where('id', $id)->first();
            $occasions->update($data);
            if(isset($images) && count(@$images)>0){
                $occasions->Files()->delete();
                foreach($images as $image){
                    $occasions->Files()->create(array('path'=>$image,'file_type'=>'image'));
                }
            }
            return true;
            
        }                
        $occasions=$this->create($data);
//        if(isset($data['image']) && !empty($data['image'])){
//            foreach($data['image'] as $image){
//                $occasions->Files()->create(array('path'=>$image,'file_type'=>'image'));
//            }        
//        }
        return $occasions;
    }
    public function getOccasions($datatable = false, $id = NULL) {
        if ($datatable == true) {
            $data=$this->get();            
            return getAuthorizedButton($data)->toJson();            
        } else if (isset($id) && !empty($id)) {
            $data=$this->with('Files')->where('id', $id)->first();
            $data['start_date']=\Carbon\Carbon::parse($data['start_date'])->format('d-m-Y');
            $data['end_date']=\Carbon\Carbon::parse($data['end_date'])->format('d-m-Y');        
            return $data;
        } else {
            return $this->with('Files')->get();
        }
    }
    public function deleteOccasion($id) {
        if (isset($id) && !empty($id)) {
            return $this->where('id', $id)->delete();
        }
        return trans('message.failure');
    }
}
