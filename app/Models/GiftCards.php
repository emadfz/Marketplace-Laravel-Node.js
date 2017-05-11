<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Datatables;
use Carbon\Carbon;

class GiftCards extends Model {

    protected $fillable = [
        'title',
        'description',
        'quantity',
        'price',
        'status',        
        'code'
    ];
    
    public function Files()
    {
      return $this->morphMany('App\Models\Files', 'imageable');
    }
    public function saveCard($data, $id = NULL,$image='') {   
        try{
            
            if (isset($id) && !empty($id)) {                            
                
                unset($data['_token']);
                unset($data['_method']);
                unset($data['code']);            
                
                $giftcard=$this->where('id', $id)->first();
                $giftcard->update($data);                
                if(isset($image) && !empty(@$image)){
                    $giftcard->Files()->delete();                    
                    foreach(@$image as $img){ 
                        $giftcard->Files()->create(array('path'=>$img,'file_type'=>'image'));
                    }
                }

                return true;
            }
            
            $data['code']=  encrypt($data['code']);                    

            $giftCard=$this->create($data);        
            if(isset($image) && !empty($image)){            
                $giftCard->Files()->create($image);
            }
            return $giftCard;
        }
        catch(\Exception $e){
            echo $e->getMessage();
        }
    }

    public function getGiftCards($datatable = false, $id = NULL) {
        
        if ($datatable == true) {
            $data=$this->with('Files')->get();            
            foreach ($data as $key => $val) {                                
                if($val->Files->count()>0  ){                    
                    $data[$key]->image=getImageByPath($val->Files->first()->path,'thumbnail');
                }
                else{
                    $data[$key]->image='';
                }
            }    
            return getAuthorizedButton($data)->toJson();            
        } else if (isset($id) && !empty($id)) {                       
            return $this->where('id', $id)->first();
        } else {
            return $this->get();
        }
    }

    public function deleteGiftcard($id) {
        if (isset($id) && !empty($id)) {
            return $this->where('id', $id)->delete();
        }
        return trans('message.failure');
    }

}
