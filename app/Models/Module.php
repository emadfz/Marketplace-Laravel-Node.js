<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'modules';

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
    protected $fillable = ['module_name','alias_name','status'];
   
    
    public function getModules($datatable = false, $id = NULL,$paginate=false) {              
        
        if ($datatable == true) {
            $data=$this->get();
            return getAuthorizedButton($data)->toJson();                        
        } else if (isset($id) && !empty($id)) {
            return $this->where('id', $id)->first();
        } else if (isset($paginate) && !empty($paginate)) {
            return $this->paginate(5);
        }
        else {            
            return $this->get(array('module_name','alias_name', 'id'));            
        }
    }    
//    public function getModulesWithLevel($id){
//        $data=$this->select('id','module_name')                                
//                ->where('')
//                ->get();                        
//        //dd($data[0]->levelModule);
//        return $data;
//    }
    
    public function levelModules()
    {
        return $this->hasMany('App\Models\Levelmodule');
    }
    
    public function available_levelModules($employee_level_id) {
        return $this->levelModules()->where('employee_level_id',$employee_level_id);
    }
    
    public static function getLevelsFromModule($module_name,$employee_level_id=''){        
        $module=self::where('module_name',$module_name)->first();
        
        if( isset($employee_level_id) && !empty($employee_level_id) ){
            return $module->available_levelModules($employee_level_id)->first();
        }        
        if(isset($module) && !empty($module)){
            
            return $module->levelModules;                
        }
        return array();
    }
    public function deleteModule($id) {
        if (isset($id) && !empty($id)) {
            return $this->where('id', $id)->delete();
        }
        return trans('message.failure');
    }
    public function saveModules($data,$id=''){
        if(isset($id) && !empty($id)){
            return $this->where('id', $id)->update($data);
        }
        return $this->create($data);
    }

}
