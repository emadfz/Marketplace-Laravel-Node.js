<?php

namespace App\Models;

use PDO;
use Illuminate\Database\Eloquent\Model;
use Datatables;
use Carbon\Carbon;
use DB;

class AdvertisementMingle extends Model {
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'avertisement_mingle';
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
    protected $fillable = ['advertisement_id', 'type', 'advr_url', 'start_date','end_date', 'no_of_days','status',
        'created_at','updated_at','deleted_at'];
    
    public function Files()
    {
        return $this->morphMany('App\Models\Files', 'imageable');
    }
    
    public function insertattrivalues($data_values,$id)
    {
        foreach($data_values['mytext'] as $k=>$v)
        {
            $all_val[] = array('attribute_values'=>$v,'attribute_id'=>$id);
        }
                
        return DB::table('attribute_values')->insert($all_val);
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
        return DB::table('avertisement_home')->where('advertisement_id', $id)->delete();
    }
}
