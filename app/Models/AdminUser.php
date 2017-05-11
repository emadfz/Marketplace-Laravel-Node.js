<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

class AdminUser extends Authenticatable {

    //protected $guard = "admin";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'professional_email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    
    public static function updateAdminUser($data, $id){
        $data['updated_at'] = Carbon::now();
        return self::where('id', $id)->update($data);
    }
    
    public static function checkUserData($where){
        $result = self::select('id', 'first_name', 'last_name', 'dob', 'confirmed', 'personal_email', 'professional_email', 'password', 'status')->where($where)->first();
        return (!is_null($result)) ? $result->toArray() : FALSE;
    }
}
