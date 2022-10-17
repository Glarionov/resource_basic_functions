<?php

namespace App\Http\Services;

use App\Events\AppointmentCreated;
use App\Http\Requests\AbstractUpdateOrCreateRequest;
use App\Models\Appointment;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class AppointmentService extends AbstractResourceService
{
    public int $itemsPerPage = 1000;

    public function __construct()
    {
        parent::__construct(new Appointment());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param array $requestData
     * @return Model
     */
    public function store(array $requestData): Model
    {
        $requestDataWithUserId = array_merge($requestData, ['user_id' => Cookie::get('id')]);
        $appointment = parent::store($requestDataWithUserId);
        AppointmentCreated::dispatch($appointment);
        return $appointment;
    }
}
