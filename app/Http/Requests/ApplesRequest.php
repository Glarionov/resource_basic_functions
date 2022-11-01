<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplesRequest extends AbstractUpdateOrCreateRequest
{
    /**
     * List of rules for "update" request
     * @var array
     */
    public static array $updateRequestRules = [
        'type_id' => ['integer', 'exists:appointments_types,id'],
        'first_name' => ['string'],
        'last_name' => ['string'],
        'email' => ['email'],
        'visit_date' => ['date'],
    ];

    /**
     * Fields required to be in "Create" requests
     * @var array
     */
    public static array $requiredToCreateFields = [
        'color',
    ];
}
