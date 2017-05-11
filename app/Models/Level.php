<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Level extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'employee_levels';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['level_name','id'];
    
    public function getLevels($datatable = false, $id = NULL) {

        if ($datatable == true) {
            $data=$this->get();            
            return getAuthorizedButton($data)->toJson();                                    
        } else if (isset($id) && !empty($id)) {
            return $this->where('id', $id)->first();
        } else {
            return $this->where('id','!=','1')->pluck('level_name', 'id')->all();
        }
    }
    public function saveLevel($data,$id=''){
        if(isset($id) && !empty($id)){
            return $this->where('id',$id)->update($data);
        }
        return $this->create($data);
    }
    public function deleteLevel($id) {
        if (isset($id) && !empty($id)) {
            $user_exist = DB::table('admin_users')
            ->where('role_id', '=', $id)
            ->first();
            if (is_null($user_exist)) {
                 $this->where('id', $id)->delete();
                 return 1;
            } else {
                return 0;
            }
        }
        return 0;
    }
}
