<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Datatables;
use Carbon\Carbon;

class DonationVendors extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'donation_vendors';

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
    protected $fillable = ['vendor_name','vendor_description', 'website_link', 'admin_fees', 'start_date', 'end_date', 'status', 'id','deleted_at'];
    
    public function getDonationVendors($id=null,$fromDate=null,$toDate=null){
        if(isset($id) && !empty($id)){
            return $this->where('id',$id)->select('donation_vendors.id', 'donation_vendors.vendor_name', 'donation_vendors.vendor_description', 'donation_vendors.website_link', 'donation_vendors.admin_fees', 'donation_vendors.start_date', 'donation_vendors.end_date', 'donation_vendors.status')->first();
        }
        if(isset($fromDate) && !empty($fromDate)){
            return $this->select('donation_vendors.id', 'donation_vendors.vendor_name', 'donation_vendors.vendor_description', 'donation_vendors.website_link','donation_vendors.admin_fees','donation_vendors.start_date', 'donation_vendors.end_date', 'donation_vendors.status')
                    
                    ->Where(function ($query) use($fromDate, $toDate) {
                          $query->whereBetween('start_date', [$fromDate, $toDate])
                            ->orWhereBetween('end_date', [$fromDate, $toDate]);
                    });
        }
            return $this->select('donation_vendors.id', 'donation_vendors.vendor_name', 'donation_vendors.vendor_description', 'donation_vendors.website_link','donation_vendors.admin_fees','donation_vendors.start_date', 'donation_vendors.end_date', 'donation_vendors.status');        
    }
    public function getFileLabelssnames($id=null){
        return $this->pluck('label_name', 'id')->all();
    }
    
    public function getLabelwithtopic($id){        
        $data=$this->select('file_labels.id', 'file_labels.label_name')                                
                ->where('file_labels.id','=',$id)
                ->get();                        
        return $data;
    }        
    public function savedonationVendor($data,$id=null){        
        if(isset($id) && !empty($id)){
            return $this->where('id',$id)->update($data);
        }        
        return $this->create($data);
    }
     public function deleteVendors($id) {
        if (isset($id) && !empty($id)) {             
            $vendors = DonationVendors::findOrFail($id);
            $vendors->delete();
        }
        return trans('message.failure');
    }
    public function incrementDepartmentTopic($id){
        $this->where('id', $id)->increment('topics');
    }
    public function decrementDepartmentTopic($id){
        $this->where('id', $id)->decrement('topics');
    }
}