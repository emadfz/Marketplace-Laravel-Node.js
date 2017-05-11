<?php

namespace App\Http\Middleware;

// First copy this file into your middleware directoy
use Closure;

class CheckRole {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {                 
        if (\Auth::guard('admin')->user()->first_name == "Super") {
            return $next($request);
        } else if ($this->checkAccess($request)) {
            return $next($request);
        } else {
            return response([
                'error' => [
                    'code' => 'INSUFFICIENT_ROLE',
                    'description' => 'You are not authorized to access this resource.'
                ]
                    ], 401);
        }
    }


    
    private function checkAccess($request) {
        
        $module_name=getCurrentModuleName();
        if($module_name=='home'){
            return true;
        }
        $ignore_array=array('logout');
        if ( (empty($module_name)) || in_array($module_name,$ignore_array) ) {//consider dashboard            
            return true;
        }
        
        $access_array = array(
            'create'=>'create_access',            
            'compose'=>'create_access',
            'reply_msg'=> 'create_access',
            'store' => 'create_access',
            'mark_as'=> 'create_access',
            'move_to' => 'create_access',            
            'edit'=>'update_access',            
            'delete'=>'delete_access',            
            'index'=>'read_access',
            'sent'=>'read_access',
            'compose'=>'create_access',            
            'trash' => 'read_access',
            'view_msg'=> 'read_access',
            'reply_msg'=> 'create_access',
            'show' => 'read_access',            
            'trash' => 'read_access',             
            'mark_as'=> 'create_access',
            'move_to' => 'create_access',
            'inbox' => 'read_access',
            'draft' => 'read_access',
            'folder' => 'read_access',
            'getMessages' => 'read_access',
            'update'=>'update_access',
        );        
        $operation_name=@$access_array[getCurrentOperation()];        
        return checkAuthorize($module_name,$operation_name);
    }

}
