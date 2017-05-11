<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProductConditionRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    protected $rules = [    
//        'name' => 'required|regex:/^[\w\d_.-]+$/',
        'name' => 'required|regex:/^[a-zA-Z0-9. ]+$/',
        
        'description' => 'required',
    ];
    
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
        if($id=$this->route('product_conditions', 'id')){            
            $id = decrypt($id);
        }
        
        $data=$this->request->all();
        $categoryIds=\App\Models\ProductConditions::
                                            where('name',$data['name'])
                                            ->where('category_id',$data['category_id'])
                                            ->where('id','!=',$id)
                                            ->count();
                                            
                                            
        $rules = $this->rules;        
        if($categoryIds>0){
            $rules['name'] = 'unique:product_conditions,name,'. @$id;
        }
        return $rules;
    }
    public function messages()
    {
        return [
            'name.unique' => 'The name has already been taken for this category.',            
        ];
    }
}
