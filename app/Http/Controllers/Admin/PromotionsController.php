<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\promotions;
use App\Models\User;
use App\Http\Requests\PromotionsRequest;

class PromotionsController extends Controller
{
    public $promotions;

    public function __construct() {
        $this->promotions = new promotions();
        $this->users = new User();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {        
        $promotions = $this->promotions->getPromotions(true);                        
        return view('admin.promotions.index', compact('promotions'));
    }

    /**
     * Show the form for creating a Occasions.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admin.promotions.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PromotionsRequest $request) {       
       try{
            $data = $request->all();                                                            
            if ($request->ajax()) {
               
                if ($this->promotions->savePromotions($data)) {
                    \Flash::success(trans('message.promotions.add_success'));
                    return response()->json([
                                'status' => 'success',
                                'redirectUrl' => route(config('project.admin_route') . 'promotions.index'),
                    ]);
                } else {
                    \Flash::success(trans('message.failure'));
                    return response()->json([
                                'status' => 'error',
                                'redirectUrl' => route(config('project.admin_route') . 'promotions.index'),
                    ]);
                }
            } else {
                \Flash::success(trans('message.failure'));
                return redirect()->route(config('project.admin_route') . 'promotions.index');
            }
        }
        catch(\Exception $e){
            //echo $e->getMessage();die;
        }
    }
    
     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {        
        $promotions = $this->promotions->getPromotions(false, decrypt($id));        
        $users = $this->users->getUsersForSelect(explode(',',$promotions->selected_users));                        
        return view('admin.promotions.edit', compact('promotions', 'id','users'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PromotionsRequest $request, $id) {
        try {
            $data = $request->except('_method','_token');            
            if ($request->ajax()) {                
                if ($this->promotions->savePromotions($data, decrypt($id))) {
                    \Flash::success(trans('message.promotions.update_success'));
                    return response()->json([
                                'status' => 'success',
                                'redirectUrl' => route(config('project.admin_route') . 'promotions.index'),
                    ]);
                } else {
                    \Flash::success(trans('message.failure'));
                    return response()->json([
                                'status' => 'error',
                                'redirectUrl' => route(config('project.admin_route') . 'promotions.index'),
                    ]);
                }
            } else {
                return redirect()->route(config('project.admin_route') . 'promotions.index');
            }
        } catch (\Exception $e) {
                //echo $e->getMessage();die;
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
            $id=decrypt($id);
            if ($this->promotions->deletePromotions($id)) {
                return response()->json([
                            'status' => 'success',
                            'msg' => trans('message.promotions.delete_success')
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
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getPrmotionUsers($id) {        
        try {                                               
            $promotions = $this->promotions->getPromotions(false, $id);                    
            $users = $this->users->getUsersForSelect(explode(',',$promotions->selected_users));                                                        
            return \view('admin.promotions.getPromotionUsers', compact('users'))->render();
        } catch (\Exception $e) {
            //echo $e->getMessage();die;
            return trans('message.failure');
        }
    }
}
