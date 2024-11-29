<?php

namespace App\Supports;

class Helper
{
    public function replaceDashFromPhoneNumber(string $phoneNumber): string
    {
        return preg_replace('/-/', '', $phoneNumber);
    }
}
