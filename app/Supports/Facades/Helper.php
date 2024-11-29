<?php

namespace App\Supports\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string replaceDashFromPhoneNumber(string $phone):string
 *
 * @see \App\Supports\Helper
 */
class Helper extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'helper';
    }
}
