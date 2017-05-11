<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class RewardPointSetting extends Model {

    protected $table = 'reward_point_settings';
    public $timestamps = false;
    protected $fillable = [
        'buyer_earns_reward_point_on_purchase_of_every',
        'reward_point_value',
        'effective_from_date',
        'admin_user_id',
        'status',
        'created_at',
        'updated_at'
    ];

    public function getActiveRewardPointSetting() {
        $result = $this->active()->orderBy('id', 'desc')->first();
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

    public function createRewardPointSetting($request) {
        $data['buyer_earns_reward_point_on_purchase_of_every'] = $request->get('buyer_earns_reward_point_on_purchase_of_every');
        $data['reward_point_value'] = $request->get('reward_point_value');
        $data['effective_from_date'] = date('Y-m-d',strtotime($request->get('effective_from_date')));
        $data['admin_user_id'] = auth()->guard('admin')->user()->id;
        $data['status'] = 'Active';
        $data['created_at'] = Carbon::now();
        return $this->create($data)->id;
    }

    public function updateInactiveRewardPointSetting($id) {
        $data['status'] = 'Inactive';
        $data['updated_at'] = Carbon::now();
        return $this->where('id', $id)->update($data);
    }

}
