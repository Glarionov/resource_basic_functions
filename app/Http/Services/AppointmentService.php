<?php

namespace App\Http\Services;

use App\Events\AppointmentCreated;
use App\Http\Requests\AbstractUpdateOrCreateRequest;
use App\Http\Resources\Appointments\AppointmentCollection;
use App\Http\Resources\Appointments\AppointmentResource;
use App\Models\Appointment;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class AppointmentService extends AbstractAdvancedResourceService
{
    public static int $itemsPerPage = 1000;

    public static string $mainModel = Appointment::class;

    protected static string $mainCollection = AppointmentCollection::class;
    protected static string $mainResource = AppointmentResource::class;

    /**
     * Store a newly created resource in storage.
     *
     * @param array $requestData
     * @return array
     */
    public static function store(array $requestData): array
    {
        $requestDataWithUserId = array_merge($requestData, ['user_id' => Cookie::get('id')]);
        $appointment = parent::store($requestDataWithUserId);
        AppointmentCreated::dispatch($appointment);
        return ['success' => true, 'data' => $appointment];
    }
}
