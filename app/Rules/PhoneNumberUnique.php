<?php

namespace App\Rules;

use App\Models\User;
use App\Supports\Facades\Helper;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PhoneNumberUnique implements ValidationRule
{
    private string $errorMessageKey = 'validation.custom.phone.unique';

    public function __construct(private ?int $userId = null) {}

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $phoneNumber = Helper::replaceDashFromPhoneNumber($value);
        $user = User::query()->where('phone', $phoneNumber)->when($this->userId, fn ($query) => $query->whereNot('id', $this->userId))->first();

        if ($user) {
            $fail(__($this->errorMessageKey));
        }
    }
}
