<?php

namespace App\Http\Requests\User;

use App\Http\Requests\FormRequest;
use App\Rules\PhoneNumberUnique;
use App\Rules\ValidPhoneNumberFormat;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', 'bail'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->id), 'bail'],
            'phone' => ['required', 'string', 'max:20', new ValidPhoneNumberFormat, new PhoneNumberUnique($this->id), 'bail'],
        ];
    }
}
