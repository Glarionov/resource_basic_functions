<?php

namespace App\Http\Controllers;

use App\Http\Middleware\EncryptCookies;
use App\Http\Services\AppointmentService;
use App\Models\Appointment;
use App\Http\Requests\AppointmentsRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Request as RequestFacade;
use Illuminate\Support\Facades\Validator;

class AppointmentsController extends Controller
{
    public function __construct()
    {
        $this->mainService = new AppointmentService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Cookie::has('id')) {
            $user = new User();
            $user->ip = RequestFacade::ip();
            $user->save();
            $id = $user->id;
            $appointments = [];
        } else {
            $id = Cookie::get('id');
            $appointments = $this->mainService->list(null, [['user_id', $id]], ['type']);
        }

        /**
         * С точки зрения реального приложения, конечно, не очень разумно сразу так посылать данные из пхп в js,
         * т.к. в нормальном SPA есть одна "точка входа" и разные эндпоинты, которые распределяются уже фронтом,
         * поэтому эндпоинт на бэке должен быть уинверсальным, без лишней инфы.
         * Но тут я решил немного сэкономить время на ajax-запрос
         */
        $appointmentTypes = \App\Models\AppointmentType::all();

        $appointmentRequest = new AppointmentsRequest();
        $validationRules = $appointmentRequest->generateInputRequestArray();

        $data = compact('appointments', 'appointmentTypes', 'validationRules');
        return response()->view('welcome', $data)->withCookie('id', $id);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\AppointmentsRequest  $request
     * @return Model
     */
    public function store(AppointmentsRequest $request)
    {
        return $this->mainService->store($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Appointment  $apointments
     * @return Model
     */
    public function show(Appointment $apointments)
    {
        return $this->mainService->show($apointments);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\AppointmentsRequest  $request
     * @param  \App\Models\Appointment  $appointments
     * @return Model
     */
    public function update(AppointmentsRequest $request, Appointment $appointments)
    {
        return $this->mainService->update($request, $appointments);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appointment  $appointments
     * @return Model
     */
    public function destroy(Appointment $appointments)
    {
        return $this->mainService->update($appointments);
    }
}
