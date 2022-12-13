<?php

namespace App\Http\Requests\UserManagement;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'old_password' =>'required',
            'new_password' => [
                'required',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
            'password_confirmation' => 'required|same:new_password'
        ];
    }
    public function messages()
    {
        return [
            'old_password.required' => 'Old Password is required!',
            'password.required' => 'New Password is required!',
            'password_confirmation.required' => 'Password confirmation is required'
        ];
    }
}
