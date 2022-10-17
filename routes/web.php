<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\AppointmentsController::class, 'index']);
