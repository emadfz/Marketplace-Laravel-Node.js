<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Http\Requests\LevelRequest;
//use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;

class LevelController extends Controller
{
    public $level;

    public function __construct() {
        $this->level = new Level();
    }
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        $levels = $this->level->getLevels(true);                        
        return view('admin.level.index', compact('levels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        return view('admin.level.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function store(LevelRequest $request)
    {           
         try{
            $data=$request->only('level_name');        
            if ($request->ajax()) {
                if ($this->level->saveLevel($data)) {                                        
                    \Flash::success(trans('message.level.add_success'));
                    return response()->json([
                                'status' => 'success',
                                'redirectUrl' => route(config('project.admin_route') . 'level.index'),
                    ]);
                } else {
                    \Flash::success(trans('message.failure'));
                    return response()->json([
                                'status' => 'error',
                                'redirectUrl' => route(config('project.admin_route') . 'level.index'),
                    ]);
                }
            } else {
                return redirect()->route(config('project.admin_route') . 'level.index');
            }
        }
        catch(\Exception $e){
            \Flash::success(trans('message.failure'));
                    return response()->json([
                                'status' => 'error',
                                'redirectUrl' => route(config('project.admin_route') . 'level.index'),
                    ]);
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
        $level = Level::findOrFail($id);

        return view('admin.level.show', compact('level'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function edit($id)
    {   $id=decrypt($id);
        $level=$this->level->getLevels(false,$id);        
        return view('admin.level.edit', compact('level'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function update($id, LevelRequest $request)
    {
         try{             
            $data=$request->only('level_name');                    
            if ($request->ajax()) {               
                $id=  decrypt($id);
                if ($this->level->saveLevel($data,$id)) {                                                            
                    \Flash::success(trans('message.level.update_success'));
                    return response()->json([
                                'status' => 'success',
                                'redirectUrl' => route(config('project.admin_route') . 'level.index'),
                    ]);
                } else {
                    \Flash::success(trans('message.failure'));
                    return response()->json([
                                'status' => 'error',
                                'redirectUrl' => route(config('project.admin_route') . 'level.index'),
                    ]);
                }
            } else {
                return redirect()->route(config('project.admin_route') . 'level.index');
            }
        }
        catch(\Exception $e){
            \Flash::success(trans('message.failure'));
                    return response()->json([
                                'status' => 'error',
                                'redirectUrl' => route(config('project.admin_route') . 'level.index'),
                    ]);
            //echo $e->getMessage();die;
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
            $del_id = $this->level->deleteLevel($id);
            if ($del_id == 1) {
                return response()->json([
                            'status' => 'success',
                            'msg' => trans('message.level.delete_success')
                ]);
            } else {
                
                //\Flash::success(trans('message.failure'));
                return response()->json([
                            'status' => 'error',
                            'msg' => trans('message.employee_exist')
                ]);
            }
        } catch (\Exception $e) {
            return trans('message.employee_exist');
        }
        
    }
}
