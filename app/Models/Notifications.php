<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    protected $fillable = [        
        'text',
        'url'
    ];
    
    
    
  
    public function notificationUsers(){
        return self::hasOne('App\Models\NotificationUsers');
    }    
    
    public static function getNotifications($user_id,$datatable=false) {                  
        $data = self::whereHas('notificationUsers',
            function($query) use ($user_id) {
                $query->where('user_id', $user_id)
                      ->where('is_read', 'no');
            }
        );
        if($datatable){
            return $data;   
        }
        return $data->get();        
    }  
    
    public function saveNotifications($data){
        return $this->create($data);                
    }    
}
