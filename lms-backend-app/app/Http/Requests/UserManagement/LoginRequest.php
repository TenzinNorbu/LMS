<?php

namespace App\Http\Requests\UserManagement;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'user_name' =>'required',
            'password' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'user_name.required' => 'User Name is required!',
            'password.required' => 'password is required!',
        ];
    }
}
