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
            'employee_full_name' => ['required','string'],
            'employment_id' => ['required','string'],
            'branch_id' => ['required','string'],
            'department_id' => ['required','string'],
            'designation' => ['required','string'],
            'phone_no' => ['required'],
            'email' => ['required','string','email','max:100','unique:users'],
            'user_id' => ['required','string'],
            'password' => ['required','confirmed','min:6'],
        ];
    }
}
