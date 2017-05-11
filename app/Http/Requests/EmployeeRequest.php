<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EmployeeRequest extends Request
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
    {        $return=[];
        if(!empty(Request::get('contract_start_date')))
        {
              $return += [
                'date_of_hire' => 'required|before:contract_start_date',
                ];

        }
        if($id = $this->route('employee', 'id'))
        {
            $id = decrypt($id);
            $return += [
                'employee_code' => 'required|unique:admin_users,employee_code,'.@$id.',id,deleted_at,NULL',
                'professional_email' => 'required|string|email|unique:admin_users,professional_email,'.@$id.',id,deleted_at,NULL',
                'personal_email' => 'required|string|email|unique:admin_users,personal_email,'.@$id.',id,deleted_at,NULL',
                'role_id' => 'required|not_in:0',
                'contact_number' => 'numeric',
                'secret_question_id' => 'required|not_in:0',
                'secret_answer' => 'required',
                'dob' => 'required|date_format:m-d-Y|before:today',
                'photo'=> 'mimes:jpg,png,jpeg,gif|min:5',
                 

            ];
            return $return;
        }
        else
        {
            $return += [
                 'employee_code' => 'required|unique:admin_users,employee_code,NULL,employee_code,deleted_at,NULL',
                'professional_email' => 'required|string|email|unique:admin_users,professional_email,NULL,professional_email,deleted_at,NULL',
                'personal_email' => 'required|string|email|unique:admin_users,personal_email,NULL,personal_email,deleted_at,NULL',
                'password'         => 'required|min:7|max:14|regex:/^((?=.*\\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%]).{6,20})/',
                'confirm_password' => 'required|same:password|min:7|max:14',
                'role_id' => 'required|not_in:0',
                'contact_number' => 'numeric',
                'secret_question_id' => 'required|not_in:0',
                'secret_answer' => 'required',
                'dob' => 'required|date_format:m-d-Y|before:today',    
                'photo'=> 'mimes:jpg,png,jpeg,gif|min:5',
     
            ];
            return $return;

        }
      
    }
    public function messages(){
        return [
            'password.regex'=>'Password Must be the combination of letters lower case and upper case , numbers and special characters like # or @ ! etc.',
            'dob.required'=>'please enter date of birth.',
            'dob.date_of_hire'=>'The Date of hire should be related to the countract start date ',
            'dob.date_format'=>'please enter Date of birth in mm-dd-yyyy format.'
        ];
    }
}
