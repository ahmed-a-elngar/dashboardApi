<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends CustomRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_name' => 'required|string|unique:users,user_name',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
            'password' => 'required|confirmed',
            'profile_picture'   => 'required|image|max:3024|mimes:jpeg,png,jpg',
            'note_title' => ['required_with:note_body', 'string'],
            'note_body' => ['required_with:note_title', 'string']
        ];
    }
}
