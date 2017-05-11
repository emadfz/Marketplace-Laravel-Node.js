<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ShippingCarrierSetting extends Model {

    protected $table = 'shipping_carrier_settings';
    public $timestamps = false;
    protected $fillable = [
        'vendor_id',
        'active_in_system',
        'additional_profit_margin',
        'effective_from_date',
        'admin_user_id',
        'status',
        'created_at',
        'updated_at'
    ];

    public function getActiveShippingCarrierSetting($id) {
        $result = $this->where('vendor_id', $id)->active()->first();
        return (empty($result)) ? $result : $result->toArray();
    }

    /**
     * Scope a query to only include active setting.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query) {
        return $query->where('status', 'Active');
    }

    public function createShippingCarrierSetting($request) {
        $data['vendor_id'] = $request->get('vendor_id');
        $data['active_in_system'] = $request->get('active_in_system');
        $data['additional_profit_margin'] = $request->get('additional_profit_margin');
        $data['effective_from_date'] = date('Y-m-d', strtotime($request->get('effective_from_date')));
        $data['admin_user_id'] = auth()->guard('admin')->user()->id;
        $data['status'] = 'Active';
        $data['created_at'] = Carbon::now();
        return $this->create($data)->id;
    }

    public function updateInactiveShippingCarrierSetting($id) {
        $data['status'] = 'Inactive';
        $data['updated_at'] = Carbon::now();
        return $this->where('id', $id)->update($data);
    }

}
