<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class forumsRequest extends Request
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
            'topic_department_id' => 'required|string|max:255',
            'topic_name' => 'required|string|max:255',
            'topic_description'=>'required',
        ];
    }
}
