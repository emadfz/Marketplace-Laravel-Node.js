<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class donationVendorsRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
         if($id=$this->route('donationvendors', 'id')){            
            $id = decrypt($id);
        }
        return [
            'vendor_name' => 'required|string|max:255|unique:donation_vendors,vendor_name,'.@$id,
            'admin_fees' => 'required|numeric|max:255',
            'website_link' => 'url',
            'start_date'=> 'required|date',
            'end_date'=> 'required|date',            
        ];
    }
}
