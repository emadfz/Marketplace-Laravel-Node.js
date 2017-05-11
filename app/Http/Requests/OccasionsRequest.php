<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class OccasionsRequest extends Request
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
        if($id=$this->route('occasions', 'id')){            
            $id = decrypt($id);
        }        
        return [           
                'name' => 'required|unique:occasions,name,'. @$id ,
                "status" => "required",
                "start_date" => "required",
                "end_date" => "required"                
        ];
    }
}
