<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ImageController extends Controller
{
    public function upload(request $request){         
        $data=$request->all();                        
        $data=uploadImage($request->file(), true,'','','occasions');                
        return $data;
    }
    
    public function removeImage(request $request){
        unsetImages($request->input('filename'),$request->input('modulename'));
        return \App\Models\Files::where('path',$request->input('filename'))->delete();
    }
}
