<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\LevelModuleRequest;
use App\Http\Controllers\Controller;
use App\Models\Levelmodule;
use App\Models\Level;
use App\Models\Module;
use Datatables;
use DB;

class LevelmoduleController extends Controller {
    public $levelModule;
    public $level;
    public $module;
    public function __construct() {
        $this->levelModule = new Levelmodule();        
        $this->level = new Level();
        $this->module = new Module();
    }    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {        
        $input['modules'] = $this->module->getModules();           
        return view('admin.levelmodule.create', compact('input'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LevelModuleRequest $request) {        
        $data_level=$request->only('level_name');
        $level=$this->level->saveLevel($data_level);
        $input['employee_level_id'] = $level->id;
        
        $data_values = $request->only('read_access','create_access','update_access','delete_access','module_id');    
        
        for($i=0;$i<count($data_values['module_id']);$i++){
            $read_access=isset($data_values['read_access'][$i])?1:0;
            $create_access=isset($data_values['create_access'][$i])?1:0;
            $update_access=isset($data_values['update_access'][$i])?1:0;
            $delete_access=isset($data_values['delete_access'][$i])?1:0;
            $module_id=$data_values['module_id'][$i];
        $data[]=array('read_access'=>$read_access,'create_access'=>$create_access,'update_access'=>$update_access,'delete_access'=>$delete_access,'module_id'=>$module_id,'employee_level_id'=>$input['employee_level_id']);
        }        
        $this->levelModule->saveLevelModules($data);        
        \Flash::success(trans('message.level_rights.add_success'));
        if ($request->ajax()) {
            return response()->json([
                        'status' => 'success',
                        'redirectUrl' => route(config('project.admin_route').'levelmodule.create'),
            ]);
        } else {
            return redirect()->route(config('project.admin_route').'levelmodule.create');
        }
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
       $input['employee_level_id']=$id;              
       $input['levels'] = $this->level->getLevels();          
       $input['level_name']=$id;
       //$this->module->getModulesWithLevel($id);
       $input['levelmodule'] = $this->levelModule->getModulesWithLevel($id);              
       //dd($input['levelmodule'][0]->module);
       $moduleIds=array_column($input['levelmodule']->toArray(),'module_id');
       
       $modules=\App\Models\Module::whereNotIn('id',$moduleIds)->get();       
       //echo count($modules);die;
       foreach($modules as $module){    
           $levelModule = new levelModule();
           $levelModule->read_access=0;
           $levelModule->create_access=0;
           $levelModule->update_access=0;
           $levelModule->delete_access=0;
           //$levelModule->id='';
           $levelModule->employee_level_id=$id;            
           $levelModule->module=new Module();           
           $levelModule->module->module_name=$module->module_name;           
           $levelModule->module->id=$module->id;           
           $input['levelmodule'][]=$levelModule;
       }               
       return view('admin.levelmodule.edit', compact('input','modules'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LevelModuleRequest $request, $id) {        
        $data_values = $request->only('read_access','create_access','update_access','delete_access','id','module_id');                                    
        for($i=0;$i<count($data_values['id']);$i++){            
            $read_access=isset($data_values['read_access'][$i])?1:0;
            $create_access=isset($data_values['create_access'][$i])?1:0;
            $update_access=isset($data_values['update_access'][$i])?1:0;
            $delete_access=isset($data_values['delete_access'][$i])?1:0;
            if(!isset($data_values['id'][$i]) || empty($data_values['id'][$i])){
                $data= array('read_access'=>$read_access,'create_access'=>$create_access,'update_access'=>$update_access,'delete_access'=>$delete_access,'employee_level_id'=>$id,'module_id'=>$data_values['module_id'][$i]);            
            }
            else{
                $data= array('read_access'=>$read_access,'create_access'=>$create_access,'update_access'=>$update_access,'delete_access'=>$delete_access);            
            }
            
            $this->levelModule->saveLevelModules($data,$data_values['id'][$i]);
        }

        \Flash::success(trans('message.level_rights.update_success'));
        
        if ($request->ajax()) {
            return response()->json([
                        'status' => 'success',
                        'redirectUrl' => route(config('project.admin_route').'levelmodule.create'),
            ]);
        } else {
            return redirect()->route(config('project.admin_route').'levelmodule.create');
        }
    }    
}
