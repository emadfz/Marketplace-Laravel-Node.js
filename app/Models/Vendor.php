<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Vendor extends Model {

    protected $table = 'vendors';
    public $timestamps = false;
    protected $fillable = [
        'vendor_name',
        'contact_person',
        'contact_number',
        'contact_email',
        'address_line1',
        'address_line2',
        'zipcode',
        'country_id',
        'state_id',
        'city_id',
        'account_number',
        'vendor_type',
        'admin_user_id',
        'status',
        'created_at',
        'updated_at'
    ];

    public function shippingCarrierSettings() {
        return $this->hasMany('App\Models\ShippingCarrierSetting')->where('status', 'Active');
    }

    public function getActiveVendorWithShippingCarrierSetting() {
        //$result = $this->with('shippingCarrierSettings')->active()->where('vendor_type', $type)->orderBy('id', 'asc')->get();
        $result = $this->with('shippingCarrierSettings')->where('vendor_type', 'Logistics')->orderBy('id', 'asc')->get();
        return (empty($result)) ? $result : $result->toArray();
    }

    public function scopeActive($query) {
        return $query->where('status', 'Active');
    }

}
