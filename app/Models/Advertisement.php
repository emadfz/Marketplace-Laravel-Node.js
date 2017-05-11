<?php

namespace App\Models;

use PDO;
use Illuminate\Database\Eloquent\Model;
use Datatables;
use Carbon\Carbon;
use DB;

class Advertisement extends Model {
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'advertisement';
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
    protected $fillable = ['advr_name', 'status', 'type','location','created_at', 'updated_at','deleted_at'];
    

    public function getalladvertisement()
    {
        $result = DB::table('advertisement as adv')
                ->select([ 'adv.id', 'adv.advr_name', 'adv.status', 'adv.type', 'adv.created_at'
                   , DB::raw(' case when  ( adv.id = adv_home.advertisement_id ) then '
                           . ' DATE_FORMAT( adv_home.start_date , "%c/%e/%Y" )'
                           . ' when ( adv.id = adv_cat.advertisement_id ) then '
                           . ' DATE_FORMAT( adv_cat.start_date , "%c/%e/%Y" ) '
                           . ' when ( adv.id = adv_mingle.advertisement_id ) then '
                           . ' DATE_FORMAT( adv_mingle.start_date , "%c/%e/%Y" ) end as start_date')
                   , DB::raw(' case when adv.id = adv_home.advertisement_id  then '
                           . ' DATE_FORMAT( adv_home.end_date , "%c/%e/%Y" )'
                           . ' when adv.id = adv_cat.advertisement_id then '
                           . ' DATE_FORMAT( adv_cat.end_date , "%c/%e/%Y" ) '
                           . ' when adv.id = adv_mingle.advertisement_id then '
                           . ' DATE_FORMAT( adv_mingle.end_date , "%c/%e/%Y" ) end as end_date')
                    ,DB::raw('adv.location as location ')
                    ])
                ->leftjoin('avertisement_home as adv_home','adv.id','=','adv_home.advertisement_id')
                ->leftjoin('avertisement_cat as adv_cat','adv.id','=','adv_cat.advertisement_id')
                ->leftjoin('avertisement_mingle as adv_mingle','adv.id','=','adv_mingle.advertisement_id')
                ->WhereNull('adv.deleted_at');
                  
        return $result;
    }
    
    public function getallpendingadvertisement()
    {
        $result = DB::table('advertisement as adv')
                ->select([ 'adv.id', 'adv.advr_name', 'adv.status', 'adv.type', 'adv.created_at' 
                    , DB::raw(' case when  ( adv.id = adv_home.advertisement_id ) then '
                           . ' DATE_FORMAT( adv_home.start_date , "%c/%e/%Y" )'
                           . ' when ( adv.id = adv_cat.advertisement_id ) then '
                           . ' DATE_FORMAT( adv_cat.start_date , "%c/%e/%Y" ) '
                           . ' when ( adv.id = adv_mingle.advertisement_id ) then '
                           . ' DATE_FORMAT( adv_mingle.start_date , "%c/%e/%Y" ) end as start_date')
                   , DB::raw(' case when adv.id = adv_home.advertisement_id  then '
                           . ' DATE_FORMAT( adv_home.end_date , "%c/%e/%Y" )'
                           . ' when adv.id = adv_cat.advertisement_id then '
                           . ' DATE_FORMAT( adv_cat.end_date , "%c/%e/%Y" ) '
                           . ' when adv.id = adv_mingle.advertisement_id then '
                           . ' DATE_FORMAT( adv_mingle.end_date , "%c/%e/%Y" ) end as end_date')
                    ,DB::raw('adv.location as location ')
                    ])
                ->leftjoin('avertisement_home as adv_home','adv.id','=','adv_home.advertisement_id')
                ->leftjoin('avertisement_cat as adv_cat','adv.id','=','adv_cat.advertisement_id')
                ->leftjoin('avertisement_mingle as adv_mingle','adv.id','=','adv_mingle.advertisement_id')
                ->where('adv.status','=',0)
                ->WhereNull('adv.deleted_at');
        return $result;
    }
    
    public function insertattrivalues($data_values,$id)
    {
        foreach($data_values['mytext'] as $k=>$v)
        {
            $all_val[] = array('attribute_values'=>$v,'attribute_id'=>$id);
        }
                
        return DB::table('attribute_values')->insert($all_val);
    }
    
    /*public function getvalues($id)
    {
        return DB::table('attribute_values')
                ->select('attribute_values')
                ->where('attribute_id','=',$id)
                ->get();
        
    }
    
    public function deletevalues($id)
    {
        return DB::table('attribute_values')->where('attribute_id', $id)->delete();
    } */
}
