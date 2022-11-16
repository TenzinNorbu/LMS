<?php

namespace App\Http\Requests\MasterData;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepartmentRequest extends FormRequest
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
            'department_code' => ['required'],
            'branch_id' =>['required'],
            'department_name' => ['required']
        ];
    }
    public function messages()
    {
        return [
            'department_code.required' => 'Department Code is required!',
            'branch_code.required' => 'Branch Id required!',
            'department_name.required' => 'Department Code is required!',
        ];
    }
}
