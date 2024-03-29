<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Datatables;
use Carbon\Carbon;
use DB;

class SenderMessageList extends Model {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    protected $table = 'msgs_sender';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'messages_id',
        'sender_employee_msgs_id',
        'sender_member_msgs_id',
        'sender_otheruser_msgs_id',
        'msg_fromid',
        'msg_sender_issuperadmin',
        'msg_status',
        'msg_isRead',
        'msg_isFlagged',
        'msg_isDeleted_by_sender',
        'msg_type',
        'msg_isMovedto_folder',
        'msg_IsReply',
        'msg_replyto_messageid',
        'msg_IsNotified',
        'updated_at',
        'created_at',
        'deleted_at',
        'id'
    ];

    public function store_sender_detail($data) {
        
        $data['sender_employee_msgs_id'] = \Auth::guard('admin')->user()->id;        
        return $this->create($data);          
    }

    public function getAllMessages($datatable = false, $id = NULL) {
        
        $result = DB::table('receiver_employee_msgs as recv_emp')
                    ->select(['sender_emp.msg_subject', 'sender_emp.msg_content' ,'recv_emp.emp_professional_email_id' , 'sender_emp.id'])
                    ->leftjoin('sender_employee_msgs as sender_emp','recv_emp.sender_employee_msgs_id', '=', 'sender_emp.id')
                    ->get();
        
        return getAuthorizedButton($result)->toJson();        
    }

    public function deletemessages($msg_ids) {
                
        if (isset($msg_ids) && !empty($msg_ids)) {
            $msg_array = explode(',',$msg_ids);
            $res = $this->whereIn('messages_id', $msg_array )->delete();            
            return $res;
        }
        return trans('message.failure');
    }
    
    public function markmessages($msg_ids)
    {
        $data = array();
        if (isset($msg_ids) && !empty($msg_ids)) {
            if($mark_type == 'read')
            {
                $data['msg_isRead'] = '1';
                $msg = trans('message.messagelist.marked_as_read');
            }
            else if($mark_type == 'unread')
            {
                $data['msg_isRead'] = null;
                $msg = trans('message.messagelist.marked_as_unread');
            }
            else if($mark_type == 'flagged')
            {
                $data['msg_isFlagged'] = '1';
                $msg = trans('message.messagelist.marked_as_flagged');
            }
            else if($mark_type == 'unflagged')
            {
                $data['msg_isFlagged'] = null;
                $msg = trans('message.messagelist.marked_as_unflagged');
            }         
            $msg_array = explode(',',$msg_ids);
            
            $result['msg'] = $msg;
            $result['query_res'] = $this->whereIn('messages_id', $msg_array )->update($data);            
            return $result;
        }
        return trans('message.failure');
    }
    
    public function movemessages( $msg_ids , $move_to_id )
    {
        $data = array();        
        if (isset($msg_ids) && !empty($msg_ids)) {            
            if( $move_to_id > 0 )
            {
                $data['msg_isMovedto_folder'] = '1';
                $data['msg_folder_id'] = $move_to_id;            
            }
            else if( $move_to_id == 0 )
            {
                $data['msg_isMovedto_folder'] = null;
                $data['msg_folder_id'] = null;                  
            }
            $data['deleted_at'] = null;
            $msg = trans('message.messagelist.moved_to');
            $msg_array = explode(',', $msg_ids );            
            $result['msg'] = $msg;
            if(count($msg_array) > 1)
            {
                $result['query_res'] = DB::table('msgs_sender')->whereIn('messages_id', $msg_array)->update($data);
            }
            else
            {   
                //$this->where('messages_id', $msg_ids)->update($data);
                $result['query_res'] = DB::table('msgs_sender')->where('messages_id', $msg_ids)->update($data);
            }            
            return $result;
        }
        return trans('message.failure');
    }
    
    public function searchUser($data)
    {
        $results = array();
        if($data['user_type'] == 'employee')
        {
            $users = DB::table('admin_users')
		->where('first_name', 'LIKE', '%'.$data['keyword'].'%')
		->orWhere('last_name', 'LIKE', '%'.$data['keyword'].'%')
                ->orWhere('personal_email', 'LIKE', '%'.$data['keyword'].'%')
                ->whereNull('deleted_at')
		->take(10)->get();
	
            foreach ($users as $value)
            {
                $results[] = [ 'id' => $value->id, 'value' => $value->first_name.' '.$value->last_name .'<'.$value->personal_email.'>' ];
            }
        }
        else if($data['user_type'] == 'member')
        {
            $users = DB::table('users')
		->where('first_name', 'LIKE', '%'.$data['keyword'].'%')
		->orWhere('last_name', 'LIKE', '%'.$data['keyword'].'%')
                ->orWhere('email', 'LIKE', '%'.$data['keyword'].'%')
                ->whereNull('deleted_at')
		->take(10)->get();
	
            foreach ($users as $value)
            {
                $results[] = [ 'id' => $value->id, 'value' => $value->first_name.' '.$value->last_name .'<'.$value->email.'>' ];
            }
        }
        else if($data['user_type'] == 'other_users')
        {
            $users = DB::table('other_users')
		->where('Name', 'LIKE', '%'.$data['keyword'].'%')
                ->orWhere('email_id', 'LIKE', '%'.$data['keyword'].'%')
                ->whereNull('deleted_at')
		->take(10)->get();
	
            foreach ($users as $value)
            {
                $results[] = [ 'id' => $value->id, 'value' => $value->Name .'<'.$value->email_id.'>' ];
            }
        }        
        return  json_encode($results);
    }

}
