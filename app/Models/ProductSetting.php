<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ProductSetting extends Model {

    protected $table = 'product_settings';
    public $timestamps = false;
    protected $fillable = ['id', 'allow_no_of_images','expiration_day','admin_user_id','status', 'created_at', 'updated_at'];

    public function getActiveProductSetting(){
        $result = $this->where('status','Active')->orderBy('id', 'desc')->first();
        return (empty($result)) ? $result : $result->toArray();
    }

    /**
     * Scope a query to only include active setting.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */

    /*public function scopeActive($query) {
        return $query->where('status', 'Active');
    }
    */

    public function createProductSetting($request){
        $data['allow_no_of_images'] = $request->get('allow_no_of_images');
        $data['expiration_day']     = $request->get('expiration_day');
        $data['admin_user_id']      = auth()->guard('admin')->user()->id;
        $data['status']             = 'Active';
        $data['created_at'] = Carbon::now();
        return $this->create($data)->id;
    }
    
    public function updateProductSetting($id)
    {
        //$data['allow_no_of_images'] = $no_of_images;
        $data['status'] = 'Inactive';
        $data['updated_at']         = Carbon::now();
        return $this->where('id', $id)->update($data);
    }
}