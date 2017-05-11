<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PromotionsRequest extends Request {

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
        if ($id = $this->route('promotions', 'id')) {
            $id = decrypt($id);
        }

//        \Validator::extend('without_spaces', function($attr, $value){
//            return preg_match('/^\S*$/u', $value);
//        });

        return [
            //'discount_type' => 'unique:promotions,name,'. @$id ,
            "discount_type" => "required",
            "discount" => "required|min:0.01|numeric" . (($this->get('discount_type') == 'percentage') ? '|max:100' : ''),
            "start_date" => "required",
            "end_date" => "required",
            //"promo_code" => 'required|without_spaces|unique:promotions,promo_code,'. @$id ,            
            'promo_code' => 'required|regex:/^\S*$/u|unique:promotions,promo_code,'. @$id,
            'users' => 'required',
            'selected_users' => 'required_if:users,select',
        ];
    }

    public function messages() {
        return [            
            'promo_code.regex' => 'Space in the Promocode not allow.',
            'discount.min' => 'Discount must be greater than 0.00',
        ];
    }

}
