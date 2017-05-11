<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AdminUserPasswordReset extends Model {

    protected $fillable = [
        'admin_user_id', 'personal_email', 'token', 'is_used', 'created_at', 'updated_at'
    ];

    public function adminUsers() {
        return $this->hasOne('App\Models\AdminUser', 'id', 'admin_user_id');
    }

    public function adminUserDetails() {
        return $this->hasOne('App\Models\EmployeeDetail', 'admin_user_id', 'admin_user_id');
    }

    public function getAdminUserDetails($resetToken) {
        $result = $this->with('adminUsers', 'adminUserDetails')->where('token', $resetToken)->first();
        if(!empty($result))
            return $result->toArray();
        else
            return [];
    }

    public static function updateAdminUserPasswordReset($data, $token){
        $data['updated_at'] = Carbon::now();
        return self::where('token', $token)->update($data);
    }
}
