<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TransationRequest extends Request
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
            'transaction_id'=>'required|unique:transactions,transaction_id',
            'vendors_id'=>'required',
            'amount_received'=>'required',
            'amount_paid'=>'required',
            'transaction_date'=>'required',
        ];
    }
}
