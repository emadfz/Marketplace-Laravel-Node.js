<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AdvertisementRequest extends Request
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
        
            return [
                'settings.*.no_advertisement' => 'required|numeric',
                'settings.*.rotational_time_ad' => 'required|numeric',
                'min_days_home_main.*' => 'required|numeric|distinct',
                'max_days_home_main.*' => 'required|numeric|distinct',
                'price_home_main.*' => 'required|numeric',
                'min_days_home_banner.*' => 'required|numeric|distinct',
                'max_days_home_banner.*' => 'required|numeric|distinct',
                'price_home_banner.*' => 'required|numeric',
                'min_days_category.*' => 'required|numeric|distinct',
                'max_days_category.*' => 'required|numeric|distinct',
                'price_category.*' => 'required|numeric',
                'min_days_mingle.*' => 'required|numeric|distinct',
                'max_days_mingle.*' => 'required|numeric|distinct',
                'price_mingle.*' => 'required|numeric',
            ];
                
    }
    
    public function messages()
    {
        return [
            'settings.*.no_advertisement.required' => 'no of advertisement is required',
            'settings.*.rotational_time_ad.required'  => 'rotational time is required',
        ];
    }
}
