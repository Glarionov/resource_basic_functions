<?php

namespace App\Http\Resources\Appointments;

use App\Http\Resources\AbstractCollection;

class AppointmentCollection extends AbstractCollection
{
    public $collects = AppointmentResource::class;
}
