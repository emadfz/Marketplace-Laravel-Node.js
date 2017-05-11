<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class departmentsRequest extends Request
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
        if($id=$this->route('departments', 'id')){            
            $id = decrypt($id);
        }

        if(!empty($id)){
            return [
                'department_name' => 'required|string|max:255|unique:topic_departments,department_name,'. @$id ,
                'color' => 'required',
                'image.*'=>'required|mimes:jpeg,gif,png',
                'department_description' => 'required',
            ];
        }else{
            return [
                'department_name' => 'required|string|max:255|unique:topic_departments,department_name,'. @$id ,
                'color' => 'required',
                'image.*'=>'required|mimes:jpeg,gif,png',
                'department_description' => 'required',
            ];
        }

    }
    public function messages(){
        return [
            'image.*.mimes'=>'Image must be a type of:jpeg,gif,png',
        ];
    }
}
