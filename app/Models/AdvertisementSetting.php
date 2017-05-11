<?php

namespace App\Models;

use PDO;
use Illuminate\Database\Eloquent\Model;
use Datatables;
use Carbon\Carbon;
use DB;

class AdvertisementSetting extends Model {
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'advertisement_settings';
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
    protected $fillable = ['no_advertisement','rotational_time_ad', 'type','updated_at','created_at','deleted_at'];    
    
    
    public function insertValues( $data_values , $id , $type )
    {
        //rearrange index of array
        $data_values_final = array();
        $data_values_final['min_days_home_main'] = array_values($data_values['min_days_home_main']);
        $data_values_final['max_days_home_main'] = array_values($data_values['max_days_home_main']);
        $data_values_final['price_home_main'] = array_values($data_values['price_home_main']);
        $data_values_final['min_days_home_banner'] = array_values($data_values['min_days_home_banner']);
        $data_values_final['max_days_home_banner'] = array_values($data_values['max_days_home_banner']);
        $data_values_final['price_home_banner'] = array_values($data_values['price_home_banner']);
        $data_values_final['min_days_category'] = array_values($data_values['min_days_category']);
        $data_values_final['max_days_category'] = array_values($data_values['max_days_category']);
        $data_values_final['price_category'] = array_values($data_values['price_category']);
        $data_values_final['min_days_mingle'] = array_values($data_values['min_days_mingle']);
        $data_values_final['max_days_mingle'] = array_values($data_values['max_days_mingle']);
        $data_values_final['price_mingle'] = array_values($data_values['price_mingle']);
        //end
        
        
        switch ($type) {
            case 'Main':
                $count = count($data_values_final['min_days_home_main']);
                break;
            case 'Banner':
                $count = count($data_values_final['min_days_home_banner']);
                break;
            case 'Category':
                $count = count($data_values_final['min_days_category']);
                break;
            case 'Mingle':
                $count = count($data_values_final['min_days_mingle']);
                break;
            default :
                $count = FALSE;
        }
        
        for($i=0;$i<$count;$i++){
        
           if($type == 'Main'){
               $all_val[] = array('min_days'=>$data_values_final['min_days_home_main'][$i],'max_days'=>$data_values_final['max_days_home_main'][$i],'price'=>$data_values_final['price_home_main'][$i],'advertisement_setting_id'=>$id);
           }else if($type == 'Banner'){
               $all_val[] = array('min_days'=>$data_values_final['min_days_home_banner'][$i],'max_days'=>$data_values_final['max_days_home_banner'][$i],'price'=>$data_values_final['price_home_banner'][$i],'advertisement_setting_id'=>$id);
           }else if($type == 'Category'){
               $all_val[] = array('min_days'=>$data_values_final['min_days_category'][$i],'max_days'=>$data_values_final['max_days_category'][$i],'price'=>$data_values_final['price_category'][$i],'advertisement_setting_id'=>$id);
           }else if($type == 'Mingle'){
               $all_val[] = array('min_days'=>$data_values_final['min_days_mingle'][$i],'max_days'=>$data_values_final['max_days_mingle'][$i],'price'=>$data_values_final['price_mingle'][$i],'advertisement_setting_id'=>$id);
           }
        }
        
        return DB::table('advertisement_prices')->insert($all_val);
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
    
    public function advertisementPrices() {
        return $this->hasMany('App\Models\AdvertisementPrice');
    }
}
