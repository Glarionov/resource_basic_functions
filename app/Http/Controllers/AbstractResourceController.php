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
use Inertia\Inertia;

abstract class AbstractResourceController extends Controller
{
    const RENDER_METHOD_INERTIA = 'inertia';

    protected static $mainService;

    protected static $requestType = null;

    protected static string $templatePrefix = '';

    protected static string $renderMethod = 'inertia';

    protected string $accept;

    public function __construct(Request $request)
    {
        $this->accept = $request->header('Accept', null);
    }

    protected static function returnResult($data, $template = null, Request $request = null)
    {

        if (static::$renderMethod === static::RENDER_METHOD_INERTIA) {

            if ($request->header('Accept', null) === 'application/json') {
                return $data;
            }

            return Inertia::render(static::$templatePrefix . $template, $data);
        }

        return $data;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = static::$mainService::list($request->all());
        static::returnResult($data, static::$templatePrefix . 'Index', $request);
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
    public function show(Request $request, int $id)
    {
        $data = static::$mainService::show($id);
        return static::returnResult($data,  'Show', $request);
//        return static::$mainService::show($id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Appointment  $apointments
     * @return Model
     */
    public function show2(Request $request, int $id)
    {
        $data = static::$mainService::show($id);
        static::returnResult($data, static::$templatePrefix . 'Show', $request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\AppointmentsRequest  $request
     * @param  \App\Models\Appointment  $appointments
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
}
