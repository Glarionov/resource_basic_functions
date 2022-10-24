<?php

namespace App\Http\Controllers;

use App\Http\Services\AppleService;

class AppleController extends AbstractResourceController
{
    protected static $mainService = AppleService::class;
}
