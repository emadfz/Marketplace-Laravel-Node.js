<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class FrontPage extends Model {

    protected $table = 'front_pages';
    protected $fillable = ['page_name', 'page_relative_path', 'front_menu_id', 'status', 'priority_order', 'position', 'created_at', 'updated_at'];

    public function createOrUpdateFrontPage($request, $id = 0){
        
        if($id == 0){
            
            $this->createFrontPage($request);
        }else{
            $this->updateFrontPage($request, $id);
        }
    }


    public function createFrontPage($request) {
        $data = $request;
        $data['created_at'] = Carbon::now();
        return FrontPage::create($request)->id;
    }
    
    public function updateFrontPage($request, $id) {
        $data = $request;
        $data['updated_at'] = Carbon::now();
        return FrontPage::where('id', $id)->update($data);
    }
    
    public function deleteFrontPage($id){
        
        return FrontPage::findOrFail($id)->delete();
    }
}
