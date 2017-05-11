<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationUsers extends Model
{
    protected $fillable = [        
        'notifications_id',
        'user_id',
        'is_read'
    ];
    public  function saveNotificationUsers($data){                
        foreach($data['user_id'] as $user_id){            
            $this->create(array('user_id'=>$user_id,'notifications_id'=>$data['notifications_id']));
        }        
        return true;
    }
    public function makeReadNotifications($id,$user_id){
        return $this->where(array('notifications_id'=>$id,'user_id'=>$user_id))
                ->update(array('is_read'=>'yes'));
    }
}
