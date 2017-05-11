<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class fileuploadRequest extends Request
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
                
        if($id=$this->route('fileuploads','id')){
            $id=decrypt($id);
        }        
        $validationArray= [
            'file_labels_id' => 'required|string|max:255',
            'category_id' => 'required|string|max:255',
            
            'file_name'=>'required|unique:file_uploads,file_name,'.@$id,
        ];
        if( !isset($id) || empty($id) ){
            $validationArray['image.*']= 'required|mimes:pdf,jpg,JPG,JPEG,png,gif';
        }
        
        
        return $validationArray;
    }
}
