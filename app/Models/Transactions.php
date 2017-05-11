<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Datatables;
use Carbon\Carbon;

class Transactions extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'transactions';

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
    protected $fillable = ['transaction_id', 'vendors_id', 'amount_received', 'amount_paid', 'transaction_date',  'is_deleted', 'updated_at', 'created_at', 'id'];
    
    public function transaction_vendors(){                        
         return $this->belongsTo('App\Models\Vendors');
    }
    
    public function getTransactions($id=null){
        if(isset($id) && !empty($id)){
            return $this->where('vendors_id',$id)->select('*')->with('transaction_vendors')->get();
        }
            return $this->select('*')->with('transaction_vendors')->get();
    }
    
    public function saveTransactions($data,$id=null){        
        if(isset($id) && !empty($id)){
            return $this->where('id',$id)->update($data);
        }        
        return $this->create($data);
    }
     public function deleteForums($id) {
        if (isset($id) && !empty($id)) {
            return $this->where('id', $id)->delete();
        }
        return trans('message.failure');
    }
    
}