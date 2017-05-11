<?php

namespace App\Models;

use PDO;
use Illuminate\Database\Eloquent\Model;
use Datatables;
use Carbon\Carbon;
use DB;

class AdvertisementCatMap extends Model {
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'advertise_map_cat';
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
    protected $fillable = ['advertise_id', 'cat_id', 'created_at','updated_at','deleted_at'];
    
    public function insertcatarray($data_values,$id)
    {
        foreach($data_values['catids'] as $k=>$v)
        {
            if($v != 0)
            {
                $all_val[] = array('cat_id'=>$v,'advertise_id'=>$id);
            }            
        }                
        return DB::table('advertise_map_cat')->insert($all_val);
    }
    
    public function getvalues($id)
    {
        return DB::table('attribute_values')
                ->select('attribute_values')
                ->where('attribute_id','=',$id)
                ->get();
        
    }
    
    public function deletevalues($id)
    {
        return DB::table('attribute_values')->where('attribute_id', $id)->delete();
    }
}
