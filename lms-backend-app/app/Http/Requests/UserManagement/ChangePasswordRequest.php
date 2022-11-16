<?php

namespace App\Http\Requests\UserManagement;

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
            'old_password' =>['required'],
            'new_password' => ['required','confirmed','min:6']
        ];
    }
    public function messages()
    {
        return [
            'old_password.required' => 'Old Password is required!',
            'new_password.required' => 'New Password id required!',
        ];
    }
}
