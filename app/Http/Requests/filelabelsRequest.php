<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class filelabelsRequest extends Request
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
        $id='';
        if($id=$this->route('labels', 'id')){
            $id = decrypt($id);
        };        
        return [
            'label_name' => 'required|string|max:255|unique:file_labels,label_name,'.@$id,
        ];
    }
}
