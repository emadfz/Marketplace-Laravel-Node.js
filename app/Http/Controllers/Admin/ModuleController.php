<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Http\Requests\ModuleRequest;

//use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;

class ModuleController extends Controller
{
    public $modules;

    public function __construct() {
        $this->modules = new Module();
    }
    
    public function index()
    {   
        $module = $this->modules->getmodules(true,'',true);                
        return view('admin.module.index', compact('module'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        return view('admin.module.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function store(ModuleRequest $request)
    {        
        try{
           $data=$request->except('_token');
            if ($request->ajax()) {                                
                if ($this->modules->saveModules($data)) {                    
                    \Flash::success(trans('message.module.add_success'));
                    return response()->json([
                                'status' => 'success',
                                'redirectUrl' => route(config('project.admin_route') . 'module.index'),
                    ]);
                } else {
                    \Flash::success(trans('message.failure'));
                    return response()->json([
                                'status' => 'error',
                                'redirectUrl' => route(config('project.admin_route') . 'module.index'),
                    ]);
                }
            } else {
                return redirect()->route(config('project.admin_route') . 'module.index');
            }
        }
        catch(\Exception $e){
            //echo $e->getMessage();die;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function show($id)
    {
        $module = Country::findOrFail($id);

        return view('admin.module.show', compact('module'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function edit($id)
    {
        $id=decrypt($id);
        $module = Module::findOrFail($id);
        return view('admin.module.edit', compact('module'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function update($id, ModuleRequest $request)
    {
         try {
            $data=$request->except('_token','_method');            
            if ($request->ajax()) {              
                if ($this->modules->saveModules($data,decrypt($id))) {                                    
                    \Flash::success(trans('message.module.update_success'));
                    return response()->json([
                                'status' => 'success',
                                'redirectUrl' => route(config('project.admin_route') . 'module.index'),
                    ]);
                } else {
                    \Flash::success(trans('message.failure'));
                    return response()->json([
                                'status' => 'error',
                                'redirectUrl' => route(config('project.admin_route') . 'module.index'),
                    ]);
                }
            } else {
                return redirect()->route(config('project.admin_route') . 'module.index');
            }
        } catch (\Exception $e) {
            echo $e->getMessage();die;
        }        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function destroy($id)
    {
         try {
                $id = decrypt($id);                            
                if ($this->modules->deleteModule($id)) {
                    return response()->json([
                                'status' => 'success',
                                'msg' => trans('message.module.delete_success')
                    ]);
                } else {
                    \Flash::success(trans('message.failure'));
                    return response()->json([
                                'status' => 'error',
                                'msg' => trans('message.failure')
                    ]);
                }
        } catch (\Exception $e) {
            return trans('message.failure');
        }        
    }
}
