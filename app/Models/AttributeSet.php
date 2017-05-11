<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Validation\ValidatesRequests;

class AttributeSet extends Model {
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'attribute_sets';
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
    protected $fillable = ['attribute_set_name', 'attribute_set_description', 'is_visible', 'is_deleted'];

    public function getdatatablelist()
    {
        $attributeset = $this->select([ 'attribute_sets.id', 'attribute_sets.attribute_set_name'
                    , 'attribute_sets.attribute_set_description'
                    ])                
                ->where([['attribute_sets.is_deleted', '=', 0 ]]);
        return $attributeset;
    }
    
    public function insertattricategory($data_values,$attri_id)
    {      
        foreach($data_values as $k=>$v)
        {
            $all_data[] = array('attribute_set_categoryid'=>$v,'attribute_set_id'=>$attri_id);
        }        
        $res = DB::table('attribute_set_categories')->insert($all_data);
        return $res;
        
    }
    
    public function getdatatodisplay($id)
    {
        $input['attributeset'] = DB::table('attribute_sets as a_set')
                ->select([ 'a_set.id'
                    ,'a_set.attribute_set_name'
                    ,'a_set.attribute_set_description'
                    
                    ])
                ->leftJoin('attribute_set_categories AS a_cat', 'a_cat.attribute_set_id', '=', 'a_set.id')
                ->where([['a_set.is_deleted', '=', 0 ],['a_set.id','=',$id ]])
                ->first();
        
        $input['attribute_cat'] = AttributeSetCategory::where('attribute_set_id','=',$id)->pluck('attribute_set_categoryid', 'id')->all();        
        return $input;
    }
    
    public function deleteattrisetcat($id)
    {
        $res = DB::table('attribute_set_categories')->where('attribute_set_id', $id)->delete();
        return $res;
    }
}
