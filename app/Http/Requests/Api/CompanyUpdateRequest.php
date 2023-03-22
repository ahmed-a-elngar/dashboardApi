<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Requests\Api\CustomRequest;

class CompanyUpdateRequest extends CustomRequest
{
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'      =>  ['required', 'string', 'unique:companies,name,' . $this->route('company') . ',id'],
            'email'     =>  ['required', 'email', 'unique:companies,email,' . $this->route('company') . ',id'],
            'website'   =>  ['required', 'string', 'unique:companies,website,'. $this->route('company') . ',id'],
            'note_title' => ['required_with:note_body', 'string'],
            'note_body' => ['required_with:note_title', 'string']
        ];
    }

}
