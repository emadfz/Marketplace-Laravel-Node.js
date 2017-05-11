<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    //
    protected $table = 'forum_comments';

    public function user(){
    	return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
 
}
