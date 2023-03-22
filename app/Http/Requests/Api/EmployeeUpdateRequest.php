<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeUpdateRequest extends CustomRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name'      =>  ['required', 'string'],
            'last_name'     =>  ['required', 'string'],
            'company_id'   =>  ['required', 'numeric', 'exists:companies,id'],
            'email' => ['required', 'email',  'unique:employees,email,'. $this->route('employee') . ',id'],
            'phone' => ['required', 'string', 'unique:employees,phone,'. $this->route('employee') . ',id'],
            'note_title' => ['required_with:note_body', 'string'],
            'note_body' => ['required_with:note_title', 'string']
        ];
    }
}
