<?php

namespace App\Http\Requests\User;

use App\Http\Requests\FormRequest;

class DeleteUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => ['required', 'integer', 'exists:users', 'bail'],
        ];
    }
}
