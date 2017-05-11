<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Http\Requests\CountryRequest;
//use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;

class CountryController extends Controller
{
    
    public $country;

    public function __construct() {
        $this->country = new Country();
    }
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        
        $countries=$this->country->getCountry(true);        
        return view('admin.country.index', compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        return view('admin.country.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function store(CountryRequest $request)
    {   
        try{
            $data=$request->only('country_code','country_name');        
            if ($request->ajax()) {                        
                if ($this->country->saveCountry($data)) {                                        
                    \Flash::success(trans('message.country.add_success'));
                    return response()->json([
                                'status' => 'success',
                                'redirectUrl' => route(config('project.admin_route') . 'country.index'),
                    ]);
                } else {
                    \Flash::success(trans('message.failure'));
                    return response()->json([
                                'status' => 'error',
                                'redirectUrl' => route(config('project.admin_route') . 'country.index'),
                    ]);
                }
            } else {
                return redirect()->route(config('project.admin_route') . 'country.index');
            }
        }
        catch(\Exception $e){
                    \Flash::success(trans('message.failure'));
                    return response()->json([
                                'status' => 'error',
                                'redirectUrl' => route(config('project.admin_route') . 'country.index'),
                    ]);            
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
        $country = Country::findOrFail($id);

        return view('admin.country.show', compact('country'));
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
        $country=$this->country->getCountry(false,$id);        
        return view('admin.country.edit', compact('country'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function update($id, CountryRequest $request)
    {   
        try{             
            $data=$request->only('country_code','country_name');                            
            if ($request->ajax()) {               
                $id=  decrypt($id);
                if ($this->country->saveCountry($data,$id)) {
                    \Flash::success(trans('message.country.update_success'));
                    return response()->json([
                                'status' => 'success',
                                'redirectUrl' => route(config('project.admin_route') . 'country.index'),
                    ]);
                } else {
                    \Flash::success(trans('message.failure'));
                    return response()->json([
                                'status' => 'error',
                                'redirectUrl' => route(config('project.admin_route') . 'country.index'),
                    ]);
                }
            } else {
                return redirect()->route(config('project.admin_route') . 'country.index');
            }
        }
        catch(\Exception $e){
            \Flash::success(trans('message.failure'));
                    return response()->json([
                                'status' => 'error',
                                'redirectUrl' => route(config('project.admin_route') . 'country.index'),
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
            if ($this->country->deleteCountry($id)) {
                return response()->json([
                            'status' => 'success',
                            'msg' => trans('message.country.delete_success')
                ]);
            } else {
                \Flash::success(trans('message.failure'));
                return response()->json([
                            'status' => 'error',
                            'msg' => trans('message.failure')
                ]);
            }
        } catch (\Exception $e) {
            \Flash::success(trans('message.failure'));
            return trans('message.failure');
        }       
    }
}
