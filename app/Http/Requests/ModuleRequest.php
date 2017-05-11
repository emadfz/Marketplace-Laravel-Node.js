<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ModuleRequest extends Request
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
        if($id=$this->route('module', 'id')){            
            $id = decrypt($id);
        }        
        return [
            'module_name' => 'required|unique:modules,module_name,' . @$id,                
        ];
    }
}