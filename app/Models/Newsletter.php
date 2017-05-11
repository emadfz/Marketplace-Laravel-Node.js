<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Newsletter extends Model {

    protected $fillable = ['newsletter_title', 'newsletter_content', 'newsletter_date', 'status', 'admin_user_id', 'created_at', 'deleted_at'];
    public $timestamps = false;

    public function getNewsletter($id = '', $cron = FALSE) {
        if ($cron) {
            // active newsletter of current date
            return $this->active()->currentDate()->get()->toArray();
        }

        if (isset($id) && $id != '') {
            return $this->where('id', $id)->first();
        }
        return $this->get()->toArray();
    }

    public function createNewsletter($request) {
        $data = $request->all();
        $data['admin_user_id'] = auth()->guard('admin')->user()->id;
        $data['created_at'] = Carbon::now();
        return $this->create($data)->id;
    }

    public function updateNewsletter($request, $id) {
        $data = $request->except(['_method', '_token', 'resend']);
        $data['updated_at'] = Carbon::now();
        return $this->where('id', $id)->update($data);
    }

    /**
     * Scope a query to only include active setting.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query) {
        return $query->where('status', 'Active');
    }

    public function scopeCurrentDate($query) {
        $dt = Carbon::today();
        $currentDate = $dt->format('Y-m-d');
        return $query->where('newsletter_date', $currentDate);
    }

    public function updateCronNewsletter($data, $id) {
        $data['updated_at'] = Carbon::now();
        return $this->where('id', $id)->update($data);
    }

}
