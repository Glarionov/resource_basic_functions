<?php

namespace App\Http\Resources\Appointments;

use App\Http\Resources\AbstractResource;
use App\Models\Appointment;

class AppointmentResource extends AbstractResource
{
    /** @var Appointment */
    public $resource;

    const SIMPLE_FIELDS = ['user_id'];

    const PRETTY_DATE_FIELDS = ['created_at'];

    const CHAIN_FIELDS = [
        'type' => ['type', 'name']
    ];
}
