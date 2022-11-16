<?php

namespace App\Http\Requests\MasterData;

use Illuminate\Foundation\Http\FormRequest;

class StoreBranchRequest extends FormRequest
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
            'branch_code' => ['required','string'],
            'branch_name'  => ['required','string']
        ];
    }
    public function messages()
    {
        return [
            'branch_code.required' => 'Branch Code is required!',
            'branch_name.required' => 'Branch Name id required!',
        ];
    }
}
