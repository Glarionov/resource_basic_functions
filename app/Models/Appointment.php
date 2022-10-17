<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    public $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'visit_date',
        'type_id',
    ];

    /**
     * Get the type associated with the AppointmentType.
     */
    public function type(): object
    {
        return $this->belongsTo(AppointmentType::class, 'type_id');
    }
}
