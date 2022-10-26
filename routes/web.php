<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Helpers\RouteConstructor\RouteConstructor;
use App\Http\Controllers\OrganizationsController;

Route::get('/', function () {
    return Inertia::render('Event/Show', [
        'event' => 'event',
    ]);

//    return view('welcome');
});

Route::get('apl', [\App\Http\Controllers\AppleController::class,'apple']);

RouteConstructor::constructWebRoutes();
Route::put('organizations/{organization}', [OrganizationsController::class, 'update'])
    ->name('organizations.update');
