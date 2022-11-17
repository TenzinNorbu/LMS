<?php

namespace App\Http\Requests\UserManagement;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'employee_full_name' => 'required|string',
            'employment_id' => 'required',
            'branch_id' => 'required',
            'department_id' => 'required',
            'designation' => 'required|string',
            'phone_no' => 'required|min:8|max:8',
            'email' => 'required|email|max:50|unique:users',
            'user_id' => 'required',
            'password' => 'required|confirmed|min:6'
        ];
    }

    public function messages()
    {
        return [
            'employee_full_name.required' => 'name is required!',
            'employment_id.required' => 'employee id required!',
            'branch_id.required' => 'branch name is required!',
            'department_id.required' => 'department name is required!',
            'designation.required' => 'designation is required!',
            'phone_no.required' => 'phone no is required!',
            'email.required' => 'email is required!',
            'user_id.required' => 'user id is required!',
            'password.required' => 'password is required!'
        ];
    }
}
