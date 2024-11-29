<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidPhoneNumberFormat implements ValidationRule
{
    private string $errorMessageKey = 'validation.custom.phone.invalid_format';

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! preg_match('/^01\d{1}-\d{7,8}$/', $value)) {
            $fail(__($this->errorMessageKey));
        }
    }
}
