<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\MessageFolder;

//use Illuminate\Http\Request;
use Datatables;
use Carbon\Carbon;
use Session;

class MessageFolderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    
    public $MessageFolder_obj ;
    
    public function __construct() 
    {
        $this->MessageFolder_obj = new MessageFolder();    
    }

    public function index() {
        $folders = $this->MessageFolder_obj->allfoldername(true);        
        return view('admin.messagefolder.index', compact('folders'));
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
        
   
    public function datatableList() {
        $folders = $this->MessageFolder_obj->allfoldername(true);
        return Datatables::of($folders)
                        ->addColumn('action', function ($fld) {
                            return '<input type="hidden" name="edit_path" class="edit_path" value="'.route(config('project.admin_route').'messagefolder.show', ['id'=>encrypt($fld->id)]).'">'
                            . '<a href="javascript:void(0)" class="btn btn-danger btn-xs fa fa-trash-o deleteAttribute" data-toggle="modal" data-placement="top" title="Delete" data-attribute_delete_remote="' . route(config('project.admin_route').'messagefolder.destroy', encrypt($fld->id)) . '"></a>';
                        })                        
                        ->make(true);
    }
        
    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function show(Request $request)
    {   
       
        //$id = decrypt($id);
        $result = $request->all();        
        $id = decrypt($result['id']);
        $data['folder_name'] = $result['folder_name'];
        $res =  $this->MessageFolder_obj->findOrFail($id);
        $get = $res->update($data);
        
       if ($get) {            
                return response()->json([
                            'success' => 1,
                            'status' => 'success',
                            'msg' => trans('message.messagefolder.update_success')
                ]);
            } else {
                \Flash::success(trans('message.failure'));
                return response()->json([
                            'success' => 0,
                            'status' => 'error',
                            'msg' => trans('message.failure')
                ]);
            }
    }
   
    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function update($id, Request $request)
    {
        $id = decrypt($id);
        $test = $request->all();
        print_r($test);
        exit;
        $res =  $this->MessageFolder_obj->findOrFail($id);
        $res->update($request->all());

        Session::flash('flash_message', 'State updated!');

        return redirect('/admin/state');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    
    public function destroy($id, Request $request)
    {                
        $id = decrypt($id);
        
        try {
            $data = $this->MessageFolder_obj->find($id);            
            $data->delete();
            
            if ($request->ajax()) {
                return response(['msg' => trans('message.messagefolder.delete_success'), 'success' => 1]);
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            return response(['msg' => $ex->errorInfo, 'success' => 0]);            
        }
    }
}
