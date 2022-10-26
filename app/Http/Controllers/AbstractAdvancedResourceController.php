<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppointmentsRequest;
use App\Http\Services\AbstractAdvancedResourceService;
use App\Http\Services\AbstractResourceService;
use App\Http\Services\AppointmentService;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Request as RequestFacade;

abstract class AbstractAdvancedResourceController extends AbstractResourceController
{

    protected static $mainService = AbstractAdvancedResourceService::class;

    /**
     * Delete resources in storage by filter
     *
     * @param Request $request
     * @return mixed
     */
    public function destroyByFilter(Request $request)
    {
        $data = static::$mainService::destroyByFilter($request->all());
        return static::returnResult($data,  null, $request);
    }

    /**
     * Update resources in storage by filter
     *
     * @param Request $request
     * @return mixed
     */
    public function updateByFilter(Request $request)
    {
        $data = static::$mainService::updateByFilter($request->all());
        return static::returnResult($data,  null, $request);
    }
}
