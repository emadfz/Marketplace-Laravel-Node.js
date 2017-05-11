<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class MakeAnOfferSetting extends Model {

    protected $table = 'make_an_offer_settings';
    public $timestamps = false;
    protected $fillable = ['time_to_retract_offer', 'admin_user_id', 'status', 'created_at', 'updated_at'];

    public function getActiveMakeAnOfferSetting(){
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
    
    public function createMakeAnOfferSetting($request){
        $data['time_to_retract_offer'] = $request->get('time_to_retract_offer');
        $data['admin_user_id'] = auth()->guard('admin')->user()->id;
        $data['status'] = 'Active';
        $data['created_at'] = Carbon::now();
        return $this->create($data)->id;
    }
    
    public function updateInactiveMakeAnOfferSetting($id){
        $data['status'] = 'Inactive';
        $data['updated_at'] = Carbon::now();
        return $this->where('id', $id)->update($data);
    }

}
