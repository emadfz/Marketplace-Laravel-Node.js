<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\MessageList;
use App\Models\SenderMessageList;
use App\Models\ReceiverMessageList;
use App\Models\EmployeeDepartment;
use App\Models\MessageFolder;

use App\Http\Requests\MessageListRequest;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;

class MessageListController extends Controller {

    public $messagelist;
    public $emp_msg_list;
    public $allfolders;

    public function __construct() {
        $this->messagelist = new MessageList();
        $this->sendermessagelist = new SenderMessageList();
        $this->receivermessagelist = new ReceiverMessageList();
        $this->EmployeeDepartment = new EmployeeDepartment();
        $this->messagefolder = new MessageFolder();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $type = 'inbox';
        $allfolders = $this->messagefolder->allfoldername();        
        $allmessages = $this->messagelist->getAllMessages();   
        $countallmessages = $this->messagelist->counterallmessages();
        
        return view('admin.messagelist.index', compact('allmessages','type','allfolders','countallmessages'));
    }

    public function sent() {
        $type = 'sent';
        $allfolders = $this->messagefolder->allfoldername();        
        $allmessages = $this->messagelist->getAllSentMessages(); 
        $countallmessages = $this->messagelist->counterallmessages();
        
        return view('admin.messagelist.sent', compact('allmessages','type','allfolders','countallmessages'));
    }
    
    public function inbox( $user_type ){
        $type = 'inbox';
        $allfolders = $this->messagefolder->allfoldername();        
        $allmessages = $this->messagelist->getAllMessages($user_type);  
        $countallmessages = $this->messagelist->counterallmessages();        
        if($user_type == 'employee')
        {
            $emp_dept = $this->EmployeeDepartment->pluck('department_name', 'id')->all();
        }
        return view('admin.messagelist.index', compact('allmessages','type','emp_dept','allfolders','countallmessages'));
    }
    
    public function draft() {
        $type = 'draft';
        $allfolders = $this->messagefolder->allfoldername();        
        $allmessages = $this->messagelist->getAllDraftMessages();
        $countallmessages = $this->messagelist->counterallmessages();                
        return view('admin.messagelist.index', compact('allmessages','type','allfolders','countallmessages'));
    }
    
    public function trash() {
        $type = 'trash';
        $allfolders = $this->messagefolder->allfoldername();        
        $allmessages = $this->messagelist->getAllTrashedMessages();
        $countallmessages = $this->messagelist->counterallmessages();                
        return view('admin.messagelist.index', compact('allmessages','type','allfolders','countallmessages'));
    }
    
    public function folder( $folder_name ){
        $type = 'inbox';
        $allfolders = $this->messagefolder->allfoldername();        
        $countallmessages = $this->messagelist->counterallmessages();
        $allmessages = $this->messagelist->allmessagesfromfolder($folder_name);  
       
        return view('admin.messagelist.index', compact('allmessages','type','allfolders','countallmessages','folder_name'));
    }
    
    public function view_msg(Request $request){
        $res = $request->all();        
        $message_id = $res['message_id'];
        $msg_details = $this->messagelist->getmsgdetail($message_id,$res['folder_name']);  
        $countallmessages = $this->messagelist->counterallmessages();
        $allfolders = $this->messagefolder->allfoldername();
        $view_msg = $msg_details[0];
        $this->messagelist->msgasread($message_id);
        return view('admin.messagelist.view', compact('view_msg','message_id','res','countallmessages','allfolders'));
    }
        
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatableList(Request $request) {
        return $this->messagelist->getAllMessages(true);
    }

    /**
     * Show the form for creating a Giftcards.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $allfolders = $this->messagefolder->allfoldername();
        $countallmessages = $this->messagelist->counterallmessages();
        return view('admin.messagelist.create',compact('allfolders','countallmessages'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        
        $this->validate($request, [
            'user_type' => 'required',            
            'user_emails' => 'required',
            'msg_content' => 'required'
        ]);
        
        if ($request->ajax()) {
            $employee_emails = array();
            $member_emails = array();
            $other_emails = array();
            $sender_data = array();
            $params = array();
            $res_sender = '';
            $msg_data = $request->only('msg_subject','msg_content','msg_replyto_messageid');
            
            if( !empty($msg_data['msg_replyto_messageid']) )
            {
                $sender_data['msg_IsReply'] = '1';
                $sender_data['msg_replyto_messageid'] = decrypt($msg_data['msg_replyto_messageid']);
            }
            unset($msg_data['msg_replyto_messageid']);
            
            if(!empty($msg_data['msg_subject']) || !empty($msg_data ['msg_content']))
            {
                if(trim(Input::get('save')) == 'Draft')
                {
                    $msg_data['msg_status'] = "draft";
                }                                
                $msg_res = $this->messagelist->send_message($msg_data);
                $sender_data['messages_id'] = $msg_res->id ;                
                $res_sender = $this->sendermessagelist->store_sender_detail($sender_data);                
            }
            
            if(!empty(Input::get('user_emails')) || !empty(Input::get('user_ids')))
            {
                $receiver_data = $request->only('user_emails','user_ids');
                
                if(!empty($receiver_data['user_ids']))
                {
                    $receiver_data['user_emails'] = explode(",",$receiver_data['user_ids']);
                    unset($receiver_data['user_ids']);
                }                
                $receiver_data['messages_id'] = $msg_res->id ;                
                $receiver_data['msgs_sender_id'] = $res_sender->id;
                
                $res = $this->receivermessagelist->store_receiver_detail( $receiver_data );                          
                
                if ( $res ) {
                    foreach($receiver_data['user_emails'] as $index=>$value){                        
                        \Event::fire(new \App\Events\messageEvent(explode('-',$value)[1],$msg_data['msg_subject'],\Auth::guard('admin')->user()->professional_email));
                    }                    
                    if(trim(Input::get('save')) == 'Draft'){
                        \Flash::success(trans('message.messagelist.add_draft_success'));
                    }
                    else{
                        \Flash::success(trans('message.messagelist.add_success'));
                    }
                    
                    return response()->json([
                                'status' => 'success',
                                'redirectUrl' => route(config('project.admin_route') . 'messagelist.index'),
                    ]);
                } else {
                    \Flash::success(trans('message.failure'));
                    return response()->json([
                                'status' => 'error',
                                'redirectUrl' => route(config('project.admin_route') . 'messagelist.index'),
                    ]);
                }
            }            
        } else {
            return redirect()->route(config('project.admin_route') . 'messagelist.index');
        }                            
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( Request $request ) {
        
        $res = $request->all();        
        $message_id = $res['reply_message_id'];
        $msg_details = $this->messagelist->getmsgdetail($message_id);  
        $view_msg = $msg_details[0];        
        $allfolders = $this->messagefolder->allfoldername();
        $countallmessages = $this->messagelist->counterallmessages();
        
        return view('admin.messagelist.edit',compact('allfolders','countallmessages','view_msg','msg_details','res','message_id'));
    }
       
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        try {
                $res = $request->only('data_ids','msg_type');
                $data_ids = $res['data_ids'];             
                if($res['msg_type'] == 'sent')
                {
                    $get = $this->sendermessagelist->deletemessages($data_ids);
                }
                else if($res['msg_type'] == 'inbox' || $res['msg_type'] == 'draft')
                {
                    $get = $this->receivermessagelist->deletemessages($data_ids);
                }
                else if($res['msg_type'] == 'trash')
                {
                    $get = $this->receivermessagelist->deletemessages($data_ids,'forever_delete');
                }
            if ($get) {            
                return response()->json([
                            'success' => 1,
                            'status' => 'success',
                            'msg' => trans('message.messagelist.delete_success')
                ]);
            } else {
                \Flash::success(trans('message.failure'));
                return response()->json([
                            'success' => 0,
                            'status' => 'error',
                            'msg' => trans('message.failure')
                ]);
            }
        } catch (\Exception $e) {
            return response(['msg' => $e->errorInfo, 'success' => 0]);  
        }
                
    }
    
    public function mark_as(Request $request)
    {
        try {
                $get = array();
                $res = $request->only('data_ids','msg_type','mark_type');
                $data_ids = $res['data_ids'];                
                if($res['msg_type'] == 'sent')
                {
                    $get = $this->sendermessagelist->markmessages($data_ids,$res['mark_type']);
                }
                else if($res['msg_type'] == 'inbox' || $res['msg_type'] == 'draft')
                {
                    $get = $this->receivermessagelist->markmessages($data_ids,$res['mark_type']);
                }
            if ($get['query_res']) {            
                return response()->json([
                            'success' => 1,
                            'status' => 'success',
                            'msg' => $get['msg']
                ]);
            } else {
                \Flash::success(trans('message.failure'));
                return response()->json([
                            'success' => 0,
                            'status' => 'error',
                            'msg' => trans('message.failure')
                ]);
            }
        } catch (\Exception $e) {
            return response(['msg' => $e->errorInfo, 'success' => 0]);  
        }            
                
    }
    
    public function move_to( Request $request )
    {
        try {
                $get = array();
                $res = $request->only('data_ids','msg_type','move_to');                 
                $data_ids = $res['data_ids'];                
                if($res['msg_type'] == 'sent')
                {
                    //$get = $this->sendermessagelist->movemessages($data_ids,$res['move_to']);
                }
                else if($res['msg_type'] == 'inbox' || $res['msg_type'] == 'draft' || $res['msg_type'] == 'trash')
                {                    
                    $get = $this->receivermessagelist->movemessages($data_ids,$res['move_to']);                    
                }
            if ($get['query_res']){          
                return response()->json([
                            'success' => 1,
                            'status' => 'success',
                            'msg' => $get['msg']
                ]);
            } else {
                \Flash::success(trans('message.failure'));
                return response()->json([
                            'success' => 0,
                            'status' => 'error',
                            'msg' => trans('message.failure')
                ]);
            }
        } catch (\Exception $e) {
            return response(['msg' => $e->errorInfo, 'success' => 0]);  
        }
    }        
        
    public function autocomplete(){
        
	$data['keyword'] = Input::get('keyword');
        $data['user_type'] = Input::get('user_type');
	
        echo $results = $this->messagelist->searchUser($data);	
		
    }
    
    public function addfolder(Request $request){
        
        $this->validate($request, [
            'folder_name' => 'required|string|unique:message_folders,folder_name'            
        ]);                
        
        $input = $request->all('folder_name');
        
        $data['receiver_employee_msgs_id'] = \Auth::guard('admin')->user()->id;
        $data['folder_name'] = $input['folder_name'];
        $res = $this->messagefolder->create_folder($data);   
        
        try {
            if ( $res ) {
                \Flash::success(trans('message.messagelist.add_foldername_success'));
                return response()->json([
                            'status' => 'success',
                            'msg' => trans('message.messagelist.add_foldername_success'),
                            'redirectUrl' => route(config('project.admin_route') . 'messagelist.index'),
                ]);
            } else {
                return response()->json([
                            'status' => 'error',
                            'msg' => trans('message.failure'),
                            'redirectUrl' => route(config('project.admin_route') . 'messagelist.index'),
                ]);
            }
        }catch (\Exception $e) {
            return trans('message.failure');
        }
    }
    public function getMessages(){            
            $messagelists=$this->messagelist->getmsgnotified('object');                        
            $html=view('admin.messagelist.getMessages', compact('messagelists'))->render();
            
            return response()->json([
                        'status' => 'success',
                        'html' => $html,
            ]);
    }
    
}
