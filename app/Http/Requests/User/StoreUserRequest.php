<?php

namespace App\Http\Requests\User;

use App\Http\Requests\FormRequest;
use App\Rules\PhoneNumberUnique;
use App\Rules\ValidPhoneNumberFormat;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'bail'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'bail'],
            'phone' => ['required', 'string', 'max:20', new ValidPhoneNumberFormat, new PhoneNumberUnique, 'bail'],
            'password' => ['required', 'string', Password::min(6)->uncompromised(), 'bail'],
        ];
    }
}
