<?php

namespace App\Models;

use PDO;
use Illuminate\Database\Eloquent\Model;
use Datatables;
use Carbon\Carbon;
use DB;

class AdvertisementPrice extends Model {
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'advertisement_prices';
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
    protected $fillable = ['advertisement_setting_id','min_days', 'max_days','price','updated_at','created_at','deleted_at'];    
    
    
    
}
