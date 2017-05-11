<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;
class User extends Authenticatable {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //protected $fillable = [ 'name', 'email', 'password'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['country_code', 'secret_question', 'confirm_password', 'agree_and_accept_terms_condition_and_privacy_policy'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getUsersForSelect($ids) {
        if (isset($ids) && !empty($ids)) {
            return $this
                            ->whereIn('id', $ids)
                            ->select(\DB::RAW('concat(first_name," ",last_name) as name'), 'id')
                            ->pluck('name', 'id');
        }
    }

    public static function verifyUserByAdmin($userId, $activationCode) {
        return self::where(['id' => $userId])->update(['status' => 'Verified', 'seller_verified_datetime' => getCurrentDatetime(), 'activation_code' => $activationCode]);
    }

    /* ---------------------------------------------------------------- */
    /* -------- Following methods are copied from front side -------- */
    /* -------------------------------------------------------------- */

    public static function checkUserData($where){
        $result = self::select('id', 'first_name', 'last_name', 'date_of_birth', 'is_email_verified', 'username', 'email', 'password', 'status')->where($where)->first();
        return (!is_null($result)) ? $result->toArray() : FALSE;
    }
    
    public static function updateUser($where, $data) {
        return self::where($where)->update($data);
    }

    /**
     * Get the seller detail record associated with the user.
     */
    public function sellerDetail() {
        return $this->hasOne('App\Models\SellerDetail'); //->select('user_id', 'business_name');
    }

    /**
     * Get the address detail record associated with the user.
     */
    public function addressDetail() {
        return $this->hasMany('App\Models\UserAddress')->with('Country', 'State', 'City');
    }

    /**
     * Get secret question
     */
    public function secretQuestion() {
        return $this->hasOne('App\Models\SecretQuestion', 'id', 'secret_question_id');
    }
    
    /*
     * To get billing address information
     */

    public function addressDetailBilling() {
        //return $this->hasOne('App\Models\UserAddress')->with('Country', 'State')->where(['address_type'=>'Billing']);
        return $this->hasOne('App\Models\UserAddress')->where(['address_type' => 'Billing']);
    }

    /**
     * Get the payment card detail record associated with the user.
     */
    public function paymentCardDetail() {
        return $this->hasMany('App\Models\UserPaymentCardDetail');
    }

    /**
     * Get the login history detail record associated with the user.
     */
    public function loginHistoryDetail() {
        return $this->hasMany('App\Models\LoginHistoryUser');
    }

    /*
     * Get users data for datatable, view, edit, by id
     */

    public static function getUsersData($purpose = 'id', $id = null) {
        if ($purpose == 'datatable') {

            $resultSet = self::select(['users.*', 
                DB::raw("CONCAT(users.first_name,' ',users.last_name) AS fullname"),
                DB::raw("10 AS rating"),
                DB::raw("25 AS violations_reported"),
                DB::raw("12 AS violations_received")
                ])
                    ->with(['addressDetailBilling.Country', 'addressDetailBilling.State'])->orderBy('id','desc');
            //echo "<pre>";print_r($a->get()->toArray());die;
        } else if ($purpose == 'id') {

            $resultSet = self::select(['users.*', DB::raw("CONCAT(users.first_name,' ',users.last_name) AS fullname")])
                    ->with(['addressDetail',
                        'paymentCardDetail',
                        'sellerDetail',
                        'secretQuestion',
                        'loginHistoryDetail' => function($query) {
                            return $query->orderBy('login_history_users.id', 'desc');
                        }
                    ])
                    ->where(['id' => $id])
                    ->first()
                    ->toArray();
        }

        return $resultSet;
    }

}
