<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SecretQuestion extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'secret_questions';
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['secret_question', 'status', 'admin_user_id', 'created_at', 'deleted_at'];
    public $timestamps = false;

    public function getSecretQuestion($id = '') {
        if (isset($id) && $id != '') {
            return $this->where('id', $id)->first()->toArray();
        }
        return $this->get()->toArray();
    }

    public function createSecretQuestion($request) {
        $data = $request->all();
        $data['admin_user_id'] = auth()->guard('admin')->user()->id;
        $data['status'] = 'Active';
        $data['created_at'] = Carbon::now();
        return $this->create($data)->id;
    }

    public function updateSecretQuestion($request, $id) {
        $data['status'] = 'Inactive';
        $data['deleted_at'] = Carbon::now();
        return $this->where('id', $id)->update($data);
    }

}
