<?php

namespace App\Http\Controllers;

use App\Http\Middleware\EncryptCookies;
use App\Http\Services\AppointmentService;
use App\Models\Appointment;
use App\Http\Requests\AppointmentsRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Request as RequestFacade;
use Illuminate\Support\Facades\Validator;

class AppointmentsController extends AbstractAdvancedResourceController
{
    protected static $mainService = AppointmentService::class;

    protected static $requestType = AppointmentsRequest::class;
}
