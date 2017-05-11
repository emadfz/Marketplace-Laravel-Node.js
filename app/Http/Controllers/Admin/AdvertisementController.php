<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Hash;

use Datatables;
use DB;

//// All Model files 
use App\Models\Category;
use App\Models\Advertisement;
use App\Models\AdvertisementHome;
use App\Models\AdvertisementCategory;
use App\Models\AdvertisementMingle;
use App\Models\AdvertisementCatMap;
use App\Models\AdvertisementSetting;
use App\Models\Files;
use App\Http\Requests\AdvertisementRequest;

class AdvertisementController extends Controller
{
    public function __construct()
    {
        $this->Advertisement_obj = new Advertisement();
        $this->AdvertisementHome_obj = new AdvertisementHome();
        $this->AdvertisementCategory_obj = new AdvertisementCategory();
        $this->AdvertisementMingle_obj = new AdvertisementMingle();
        $this->AdvertisementCatMap_obj = new AdvertisementCatMap();
        $this->AdvertisementSetting_obj = new AdvertisementSetting();
        $this->Files_obj = new Files();
    }
    
    public function index()
    {
        return view('admin.advertisements.index');
    }
    
    public function datatableList(Request $request) {
               
        $advertisement = $this->Advertisement_obj->getalladvertisement();
        
        return Datatables::of($advertisement)
                        ->addColumn('action', function ($fld) {
                            $extra_column = '<input type="hidden" name="edit_path" class="edit_path" value="'.route(config('project.admin_route').'advertisements.show', ['id'=>encrypt($fld->id)]).'">';                            
                            return $extra_column
                            . '<a href="javascript:void(0)" class="btn btn-danger btn-xs fa fa-trash-o deleteAttribute" data-toggle="modal" data-placement="top" title="Delete" data-attribute_delete_remote="' . route(config('project.admin_route').'adver.destroy', encrypt($fld->id)) . '"></a>';
                        })                        
                        ->make(true);
    }
    
    public function pendingadv()
    {
        return view('admin.advertisements.pendingadv');
    }
    
    public function datatableListPendingadv(Request $request) {
               
        $advertisement = $this->Advertisement_obj->getallpendingadvertisement();   
        return Datatables::of($advertisement)
                        ->addColumn('action', function ($fld) {
                            $extra_column = '<input type="hidden" name="edit_path" class="edit_path" value="'.route(config('project.admin_route').'advertisements.show', ['id'=>encrypt($fld->id)]).'">';
                            if($fld->status == 0)
                            {
                                $extra_column = '<button class="btn btn-sm btn-success table-group-action-submit approveAttribute" type="button" data-attribute_approve_remote="' . route(config('project.admin_route').'adver.approve_advr', ['id'=>encrypt($fld->id)]) . '"><i class="fa fa-check"></i> '.trans('message.Approve').'</button>';
                            }
                            return $extra_column
                            . '<a href="javascript:void(0)" class="btn btn-danger btn-xs fa fa-trash-o deleteAttribute" data-toggle="modal" data-placement="top" title="Delete" data-attribute_delete_remote="' . route(config('project.admin_route').'adver.destroy', encrypt($fld->id)) . '"></a>';
                        })                        
                        ->make(true);
    }
    
    public function create() {
        $input['all_categories'] = Category::where('parent_id', 0)->pluck('text', 'id')->all();  
        return view('admin.advertisements.create',compact('input'));
    }
    
    public function  insertsetting(AdvertisementRequest $request){
        
        
        \DB::table('advertisement_settings')->truncate();
        \DB::table('advertisement_prices')->truncate();
        
        $user_data = $request->all();
        
        // Start transaction!
        DB::beginTransaction();
        try {
            
            foreach($user_data['settings'] as $key => $value){
                $data['no_advertisement']   = $value['no_advertisement'];
                $data['rotational_time_ad'] = $value['rotational_time_ad'];
                $data['type'] = $key;
                $setting_id = $this->AdvertisementSetting_obj->create($data);   

                $res_attri_values = $this->AdvertisementSetting_obj->insertValues($user_data,$setting_id->id,$key);
            } 
        
        }catch (Exception $ex) {
            // Rollback transaction
            DB::rollBack();
            // back to form with errors
            return response()->json(['status' => 'error', 'messages' => ['global_form_message' => trans('message.failure')]]);
        }
        
        // If we reach here, then data is valid and working. Commit the queries!
        DB::commit();
        
        \Flash::success(trans('message.advertisementsgeneralsettings.add_success'));
                if ($request->ajax()) {
                    return response()->json([
                                'status' => 'success',
                                'redirectUrl' => route(config('project.admin_route').'advertisements.index'),
                    ]);
                } else {
                    return redirect()->route(config('project.admin_route').'advertisements.index');
                }
    }

    public function store(Request $request)
    { 
     
        $check_if_cat_selected = $request->only('add_to_display');        
        if( $check_if_cat_selected['add_to_display'] == 'category_page' )
        {
            $validate_array = array(
                'add_to_display' =>'required',            
                'advr_name'=>'required|string|unique:advertisement,advr_name',
                'type'=>'required|string',
                'advr_url'=>'required|url|max:100',                   
                'start_date'=>'required',                  
                'cat_id'=>'required|not_in:0',
                'available_days'=>'required|integer',
                "upload_image.*" => 'required|mimes:jpeg,jpg,gif,png',
            );            
        }
        else if( $check_if_cat_selected['add_to_display'] == 'subcategory_page' )
        {
            $validate_array = array(
                'add_to_display' =>'required|not_in:0',            
                'advr_name'=>'required|string|unique:advertisement,advr_name',
                'type'=>'required|string',
                'advr_url'=>'required|url|max:100',
                'start_date'=>'required',                  
                'cat_id'=>'required|not_in:0',     
                'available_days'=>'required|integer',
                "upload_image.*" => 'required|mimes:jpeg,jpg,gif,png',
            );
        }
        else
        {
            $validate_array = array(
                'add_to_display' =>'required|not_in:0',            
                'advr_name'=>'required|string|unique:advertisement,advr_name',
                'type'=>'required|string',
                'advr_url'=>'required|url|max:100',             
                'start_date'=>'required',      
                'available_days'=>'required|integer|min:1',
                "upload_image.*" => 'required|mimes:jpeg,jpg,gif,png',
            );
        }
        $message=[
            "upload_image.*.required" => 'Image id Required!!',            
            'upload_image.*.mimes'=>'Image must be a file of type : jpeg,jpg,gif,png'
        ];
        $this->validate( $request, $validate_array,$message);                  
        $adv = $request->only('advr_name','type','add_to_display','start_date','available_days','advr_url');      
        $adv['end_date']=date('Y-m-d', strtotime($adv['start_date'].' + '.$adv['available_days'].' days')); 
        
        if( $adv['add_to_display'] == 'home_page' )
        {
            $adv['location'] = 'Home';
        }
        else if($adv['add_to_display'] == 'category_page')
        {
            $adv['location'] = 'Category';
        }
        else if($adv['add_to_display'] == 'subcategory_page')
        {
            $adv['location'] = 'SubCategory';
        }
        else if($adv['add_to_display'] == 'mingle_page')
        {
            $adv['location'] = 'Mingle';
        }
        
        $res = $this->Advertisement_obj->create($adv);       
        
        if(!empty($res->id))
        {
            $image = array();
            $image_data = array();
            $adv = $request->only('type','add_to_display','start_date','available_days','advr_url');
            $adv['end_date']=date('Y-m-d', strtotime($adv['start_date'].' + '.$adv['available_days'].' days')); 
            $adv['advertisement_id'] = $res->id;
                       
            if ($request->hasFile('upload_image')) {
                    $image = uploadImage($request->file('upload_image'),false);  
                    $image_data['path'] = $image['path'];
                    $image_data['imageable_id'] = $res->id;
                    $image_data['file_type'] = $image['file_type'];                    
            }                       
            
            if( $adv['add_to_display'] == 'home_page' )
            {
                unset($adv['add_to_display']);                
                $res_adv_detail = $this->AdvertisementHome_obj->create($adv)->Files()->create($image_data);
            }
            else if($adv['add_to_display'] == 'category_page' || $adv['add_to_display'] == 'subcategory_page')
            {
                unset($adv['add_to_display']);                
                $res_adv_detail = $this->AdvertisementCategory_obj->create($adv)->Files()->create($image_data);                
                $adv_cat = $request->only('cat_id');                
                $all_cats['catids'] = $adv_cat['cat_id'];
                $this->AdvertisementCatMap_obj->insertcatarray($all_cats,$adv['advertisement_id']);
            }
            else if($adv['add_to_display'] == 'mingle_page')
            {
                unset($adv['add_to_display']);
                $res_adv_detail = $this->AdvertisementMingle_obj->create($adv)->Files()->create($image_data);
            }
            
            if( $res_adv_detail )
            {
                \Flash::success(trans('message.advertisements.add_success'));
                if ($request->ajax()) {
                    return response()->json([
                                'status' => 'success',
                                'redirectUrl' => route(config('project.admin_route').'advertisements.index'),
                    ]);
                } else {
                    return redirect()->route(config('project.admin_route').'advertisements.index');
                }
            }
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
        
    }
    
    public function checkavailabledate(Request $request)
    {
        $requestall = $request->all();
        print_r($requestall['start_date']);
    }
    
    public function approve_advr(Request $request)
    {
        $requestall = $request->all();
        
        $id = decrypt($requestall['id']);
        $data_advr['status'] = 1;
        try {
            $res = $this->Advertisement_obj->where('id', $id )->update($data_advr);        
            $reshome = $this->AdvertisementHome_obj->where('advertisement_id', $id )->update($data_advr);
            $rescat = $this->AdvertisementCategory_obj->where('advertisement_id', $id )->update($data_advr);
            $resmingle = $this->AdvertisementMingle_obj->where('advertisement_id', $id )->update($data_advr);
            if( $res )
            {                              
                return response(['msg' => trans('message.advertisements.approved_success'), 'success' => 1]);                    
            } 
        } catch (\Illuminate\Database\QueryException $ex) {
                return response(['msg' => $ex->errorInfo, 'success' => 0]);            
        }            
    }
    
    public function settingsadv()
    {
        $input = AdvertisementSetting::with('advertisementPrices')->get()->toArray();
        $value = array();

        foreach ($input as $input) {
            $value[$input['type']] = $input;
        }
        
        return view('admin.advertisements.settingsadvertisement',compact('value'));
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
        $input['all_categories'] = Category::where('parent_id', 0)->pluck('text', 'id')->all();  
        return view('admin.advertisements.create',compact('input'));              
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
            
            $this->AdvertisementHome_obj->deletevalues($id);
            $this->AdvertisementCategory_obj->deletevalues($id);
            $this->AdvertisementMingle_obj->deletevalues($id);
            $this->Files_obj->deletevalues($id);
            
            $data = $this->Advertisement_obj->find($id);            
            $data->delete();
                                    
            if ($request->ajax()) {
                return response(['msg' => trans('message.advertisements.delete_success'), 'success' => 1]);
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            return response(['msg' => $ex->errorInfo, 'success' => 0]);            
        }
    }
    
}
