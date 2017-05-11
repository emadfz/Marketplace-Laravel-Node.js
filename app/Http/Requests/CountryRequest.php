<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CountryRequest extends Request
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

        if($id=$this->route('country', 'id')){                       
            $id = decrypt($id);
        }

        return [
            'country_code' => 'required|unique:countries,country_code,'. @$id ,            
            'country_name' => 'required|unique:countries,country_name,'. @$id ,            
        ]; 
    }
}
