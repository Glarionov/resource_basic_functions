<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppointmentsRequest;
use App\Http\Services\AppointmentService;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Request as RequestFacade;

abstract class AbstractAdvancedResourceController extends Controller
{
    protected static $mainService;

    protected static $requestType = null;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return static::$mainService::list($request->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\AppointmentsRequest  $request
     * @return Model
     */
    public function store(Request $request)
    {
        if (static::$requestType) {
            $request->validate(static::$requestType::generateInputRequestArray());
        }

        return static::$mainService::store($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Model
     */
    public function show(int $id)
    {
        return static::$mainService::show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return Model
     */
    public function update(Request $request, int $id)
    {
        if (static::$requestType) {
            $request->validate(static::$requestType::$updateRequestRules);
        }

        return static::$mainService::update($request->all(), $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appointment  $appointments
     * @return Model
     */
    public function destroy(int $id)
    {
        return static::$mainService::update($id);
    }

    /**
     * Delete resources in storage by filter
     *
     * @param Request $request
     * @return mixed
     */
    public function destroyByFilter(Request $request)
    {
        return static::$mainService::destroyByFilter($request->all());
    }

    /**
     * Update resources in storage by filter
     *
     * @param Request $request
     * @return mixed
     */
    public function updateByFilter(Request $request)
    {
        return static::$mainService::updateByFilter($request->all());
    }
}
