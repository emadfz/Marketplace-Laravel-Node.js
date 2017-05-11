<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Notifications;
use App\Models\NotificationUsers;
use Datatables;

class NotificationsController extends Controller
{
    public $notifications;
    public $user_id;

    public function __construct() {
        $this->notifications = new Notifications();     
        $this->notificationUsers= new NotificationUsers();     
        $this->user_id = \Auth::guard('admin')->user()->id;
    }
    //
    public function index(){

        $page_title = 'notifications';
        $page_description = 'notifications';
//        $notifications=$this->notifications->getNotifications($this->user_id); 
         // return $notifications;
        return view('admin.dashboard.notifications', compact('page_title', 'page_description'));
    }





    public function datatableList(Request $request) {
        try{        
                $notifications=$this->notifications->getNotifications($this->user_id,true); 
                
                
                return Datatables::of($notifications)
                    ->editColumn('url', function ($notification){
                            $url='';
                            $url.="<a href=".$notification->url.">Link</a>";
                            return $url;
                        })

                ->make(true);
        }
        catch(\Exception $e){
            echo $e->getMessage();
        }
    }




    public function getNotifications(){                        
            $notifications=$this->notifications->getNotifications($this->user_id);            
            $html=view('admin.layouts.partials.notifications', compact('notifications'))->render();            
            return response()->json([
                        'status' => 'success',
                        'html' => $html,
            ]);
    }
    
    public function readNotifications(request $request){            
        try{
            $data=$request->all();
            $id='';
            if(isset($data['id']) && !empty($data['id'])){
                $id=decrypt($data['id']);
            }
            if($this->notificationUsers->makeReadNotifications($id,$this->user_id)){
                return response()->json([
                        'status' => 'success',                        
                ]);
            }            
            else{
                return response()->json([
                        'status' => 'error',                        
                        'msg' => trans('message.failure')
                ]);
            }
        }
        catch(\Exception $e){
                return response()->json([
                        'status' => 'error',                        
                        'msg' => trans('message.failure')
                ]);
        }
    }
    
}
