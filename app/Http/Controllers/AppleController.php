<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplesRequest;
use App\Http\Services\AppleService;
use App\Http\Services\AppointmentService;

class AppleController extends AbstractAdvancedResourceController
{
    protected static $mainService = AppleService::class;

    protected static string $templatePrefix = 'Apple/';

    protected static $requestType = ApplesRequest::class;

//
//    public function apple()
//    {
//        return static::returnResult(['a' => 'b'], 'Index');
//    }
}
