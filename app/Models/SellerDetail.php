<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerDetail extends Model {

    //protected $guarded = ['position_other', 'bank_name', 'bank_phone_number', 'bank_routing_number', 'bank_account_number', 'website'];
    protected $guarded = ['position_other'];

    public static function createSellerDetail($request) {
        $data = $request;
        $data['industry_type_id'] = $request['industry_type'];
        $data['position_id'] = $request['position'];
        unset($data['industry_type'], $data['position']);
        return self::create($data);
    }

    /**
     * Get the user that owns the seller detail.
     */
    public function user() {
        return $this->belongsTo('App\Models\User');
    }
    
    /**
     * Get the industry name associated with the seller.
     */
    public function industryType() {
        return $this->hasOne('App\Models\IndustryType');
    }

}
