<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Levelmodule extends Model {
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'level_modules';
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
    protected $fillable = ['read_access','create_access','update_access','delete_access','id'];
    
    public function module(){     
         return $this->belongsTo('App\Models\module');
    }
    
    public function saveLevelModules($data,$id=null){                
        if(isset($id) && !empty($id)){
            return $this->where('id',$id)->update($data);
        }        
        return $this->insert($data);
    }
    
    public function getModulesWithLevel($id){        
        $data=$this->select('level_modules.read_access','level_modules.create_access','level_modules.update_access','level_modules.delete_access','level_modules.id','level_modules.module_id','employee_level_id')                                
                ->where('employee_level_id','=',$id)
                ->get();                        
        return $data;
    }
     public static function getLevelModulesByLevelId($id){        
            return $data=self::select('create_access','read_access','update_access','delete_access','m.module_name')->join('modules as m','m.id','=','module_id')->where('employee_level_id',$id)->get()->toArray();
            
            //dd($data);
    }

}
