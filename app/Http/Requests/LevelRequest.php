<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class LevelRequest extends Request
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
        
       if($id=$this->route('level', 'id')){                       
            $id = decrypt($id);
        }       
        
        return [                            
            'level_name' => 'required|unique:employee_levels,level_name,'. @$id ,            
        ]; 
    }
}
