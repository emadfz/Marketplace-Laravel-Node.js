<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Input;

class GiftCardsRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {        
        if (Request::segment(3)) {
            $id = decrypt(Request::segment(3));            
            return [
                "status" => "required",
                "title" => "required",
                "price" => "required|numeric",
                "image.*" => 'required|mimes:jpeg,jpg,gif,png',
                "description" => "required",
                "quantity" => "required|integer",
                'code' => 'required|unique:gift_cards,code,' . @$id,
            ];
        } else {
            return [
                "status" => "required",
                "title" => "required",
                "price" => "required|numeric",
                "image.*" => 'required|mimes:jpeg,jpg,gif,png',
                "description" => "required",
                "quantity" => "required|integer",                
                'code' => 'required|unique:gift_cards,code',
            ];
        }
        
    }
    public function messages()
    {
        return [
            'quantity.integer' => 'please enter valid quantity',            
            'image.*.mimes'=>'Image must be a file of type : jpeg,jpg,gif,png'
        ];
    }

}
