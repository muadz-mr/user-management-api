<?php

namespace App\Http\Controllers;

use App\Supports\ApiResponse;

abstract class Controller
{
    public function __construct(protected ApiResponse $apiResponse)
    {
        //
    }
}
