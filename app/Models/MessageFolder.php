<?php

namespace App\Models;

use PDO;
use Illuminate\Database\Eloquent\Model;
use Datatables;
use Carbon\Carbon;
use DB;

class MessageFolder extends Model {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'message_folders';

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
        'folder_name',
        'receiver_employee_msgs_id',
        'receiver_member_msgs_id',
        'receiver_otheruser_msgs_id',
        'id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    
    public function create_folder($data)
    {
        return $this->create($data);
    }
    
    public function allfoldername($datatable = false)
    {
        if($datatable == false)
        {
            DB::setFetchMode(PDO::FETCH_ASSOC);
            
            $result = DB::table('message_folders as fld')
                    ->select(['fld.folder_name', DB::raw(' count(recv.msg_folder_id) as folder_cnt '), 'fld.id'])
                    ->leftjoin('msgs_receiver as recv',function($join){
                                $join->on('fld.id', '=', 'recv.msg_folder_id');
                                $join->on(DB::raw('recv.msg_isRead IS NULL'),DB::raw(''),DB::raw(''));
                            })
                    ->where( 'fld.receiver_employee_msgs_id','=',\Auth::guard('admin')->user()->id )
                    ->WhereNull('fld.deleted_at')
                    ->groupby('fld.id')
                    ->orderBy('fld.folder_name', 'ASC')
                    ->get();        
            DB::setFetchMode(PDO::FETCH_CLASS);
        }
        if($datatable == true)
        {
            $result = DB::table('message_folders as fld')
                    ->select(['fld.folder_name', DB::raw(' count(recv.msg_folder_id) as folder_cnt '), 'fld.id'])
                    ->leftjoin('msgs_receiver as recv',function($join){
                                $join->on('fld.id', '=', 'recv.msg_folder_id');
                                $join->on(DB::raw('recv.msg_isRead IS NULL'),DB::raw(''),DB::raw(''));
                            })
                    ->where( 'fld.receiver_employee_msgs_id','=',\Auth::guard('admin')->user()->id )
                    ->WhereNull('fld.deleted_at')
                    ->groupby('fld.id')
                    ->orderBy('fld.folder_name', 'ASC');            
        }
        return $result;
    }        
    
}
