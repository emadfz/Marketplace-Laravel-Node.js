<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Validation\ValidatesRequests;

class Attribute extends Model {
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'attributes';
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
    protected $fillable = ['attribute_name','attribute_slug', 'attribute_description', 'is_visible','variation_allowed','attribute_set_id', 'catelog_input_type','view_in_filter','comparable','is_deleted'];

    public function datatablelist()
    {
        $attribute = DB::table('attributes')
                ->select([ 'attributes.id', 'attributes.attribute_name',   'attributes.attribute_description',                  
                    DB::raw('(CASE WHEN attributes.variation_allowed = 1 THEN "Yes" ELSE "No" END) AS variation_allowed'),
                    DB::raw('(CASE WHEN attributes.view_in_filter = 1 THEN "Yes" ELSE "No" END) AS view_in_filter'),
                    DB::raw('(CASE WHEN attributes.comparable = 1 THEN "Yes" ELSE "No" END) AS comparable')
                    ])                
                ->where([['attributes.is_deleted', '=', 0 ]]);
        
        return $attribute;
    }
    
    public function insertattrivalues($data_values,$id)
    {
        $all_val = array();
        foreach($data_values['mytext'] as $k=>$v)
        {
            if($v != '')
            {
                $all_val[] = array('attribute_values'=>$v,'attribute_id'=>$id);
            }            
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
        return DB::table('attribute_values')->where('attribute_id', $id)->delete();
    }
}
