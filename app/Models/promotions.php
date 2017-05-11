<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class promotions extends Model {

    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'promo_code',
        'discount',
        'discount_type',
        'start_date',
        'end_date',
	'selected_users',        
        'status',        
        'users_id',
        'user_type'
    ];        
    public function AdminUsers()
    {
      return $this->hasOne('App\Models\AdminUser','id','users_id');
    }
    
    public function getPromotions($datatable = false, $id = NULL) {
        
        
        
        if ($datatable == true) {
            $datas=$this->with('AdminUsers')->get(); 
            foreach($datas as $key=>$data){                
                //$datas[$key]->promo_code=decrypt($data->promo_code);
                $datas[$key]->promo_code=$data->promo_code;
            }                        
            return getAuthorizedButton($datas)->toJson();            
        } else if (isset($id) && !empty($id)) {                        
            $datas=$this->where('id', $id)->first();                        
            //$datas->promo_code=decrypt($datas->promo_code);
            $datas->promo_code=$datas->promo_code;
            return $datas;
        } else {
            return $this->get();
        }      

        
    }

    public function savePromotions($data, $id = NULL) {                
        $data['start_date']=\Carbon\Carbon::parse($data['start_date'])->format('Y-m-d');
        $data['end_date']=\Carbon\Carbon::parse($data['end_date'])->format('Y-m-d');        
        //$data['promo_code']=  encrypt($data['promo_code']);         
        $data['promo_code']=  $data['promo_code'];         
        $data['users_id']=\Auth::guard('admin')->user()->id;
        $data['user_type']='Admin';
        
        if(!isset($data['status']) || empty($data['status'])){
           $data['status']='Inactive'; 
        }
        
        if($data['users']=='select'){            
            $data['selected_users']=implode(',',$data['selected_users']);                 
        }
        else{
            $data['selected_users']='all';                     
        }
        
        
        unset($data['users']);
        
        if (isset($id) && !empty($id)) {                    
                return $this->where('id',$id)->update($data);
        }                
        
        return $this->create($data);                        
    }
    public function deletePromotions($id){
        if (isset($id) && !empty($id)) {
            return $this->where('id', $id)->delete();
        }
        return trans('message.failure');
    }

}
