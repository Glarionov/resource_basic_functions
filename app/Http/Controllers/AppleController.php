<?php

namespace App\Http\Controllers;

use App\Http\Services\AppleService;
use App\Http\Services\AppointmentService;

class AppleController extends AbstractResourceController
{
    protected static $mainService = AppleService::class;

    protected static string $templatePrefix = 'Apple/';
//
//    public function apple()
//    {
//        return static::returnResult(['a' => 'b'], 'Index');
//    }
}
