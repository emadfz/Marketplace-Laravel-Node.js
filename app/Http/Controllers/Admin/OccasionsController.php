<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\occasions;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\OccasionsRequest;

class OccasionsController extends Controller
{
    public $occasions;

    public function __construct() {        
        $this->occasions = new Occasions();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {        
        $occasions=$this->occasions->getOccasions(true);               
        return view('admin.occasions.index', compact('occasions'));
    }
     /**
     * Show the form for creating a Occasions.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admin.occasions.create');
    }
    /**
     * Store a newly created occasion in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OccasionsRequest $request) {    
        try{            
            $data = $request->all();                              
            //uploadImage($data['image'], true);                     
            if ($request->ajax()) {            
                if ($occasion=$this->occasions->saveOccasions($data)) {                    
                    \Flash::success(trans('message.occasions.add_success'));
                    return response()->json([
                                'status' => 'success',
                                'redirectUrl' => route(config('project.admin_route') . 'occasions.edit',encrypt($occasion->id)),
                    ]);
                } else {
                    \Flash::success(trans('message.failure'));
                    return response()->json([
                                'status' => 'error',
                                'redirectUrl' => route(config('project.admin_route') . 'occasions.index'),
                    ]);
                }
            } else {
                return redirect()->route(config('project.admin_route') . 'occasions.index');
            }
        }
        catch(\Exception $e){
            echo $e->getMessage();die;
        }
    }
    /**
     * Show the form for editing the Occasion.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {           
        $occasion = $this->occasions->getOccasions(false, decrypt($id));        
        return view('admin.occasions.edit', compact('occasion'));
    }
    /**
     * Update the specified occasion in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OccasionsRequest $request, $id) {
        try {                       
            $data = $request->except('_method','_token');                        
            if ($request->ajax()) {
                if ($this->occasions->saveOccasions($data, decrypt($id))) {
                    \Flash::success(trans('message.occasions.update_success'));
                    return response()->json([
                                'status' => 'success',
                                'redirectUrl' => route(config('project.admin_route') . 'occasions.index'),
                    ]);
                } else {
                    \Flash::success(trans('message.failure'));
                    return response()->json([
                                'status' => 'error',
                                'redirectUrl' => route(config('project.admin_route') . 'occasions.index'),
                    ]);
                }
            } else {
                return redirect()->route(config('project.admin_route') . 'occasions.index');
            }
        } catch (\Exception $e) {            
            echo $e->getMessage();
        }
    }
     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        try {
            $id = decrypt($id);
            if ($this->occasions->deleteOccasion($id)) {
                return response()->json([
                            'status' => 'success',
                            'msg' => trans('message.occasions.delete_success')
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
