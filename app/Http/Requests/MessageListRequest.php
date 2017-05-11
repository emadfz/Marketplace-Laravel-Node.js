<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Input;

class MessageListRequest extends Request {

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
                "image" => 'mimes:jpeg,bmp,png',
                "description" => "required",
                "quantity" => "required|numeric",
                'code' => 'unique:gift_cards,code,' . $id
            ];
        } else {
            return [
                "status" => "required",
                "title" => "required",
                "price" => "required|numeric",
                "image" => 'mimes:jpeg,bmp,png',
                "description" => "required",
                "quantity" => "required|numeric",                
            ];
        }
        
    }

}
