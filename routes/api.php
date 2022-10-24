<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources([
//    'appointments' => \App\Http\Controllers\AppointmentsController::class,
    'apples' => \App\Http\Controllers\AppleController::class,
    'tests' => \App\Http\Controllers\TestController::class
]);

$advancedRoutes = [
    'appointments' => AppointmentsController::class
];

foreach ($advancedRoutes as $route => $controller) {
    Route::apiResource($route, $controller);
    Route::delete("/$route", [$controller, 'destroyByFilter']);
    Route::patch("/$route", [$controller, 'updateByFilter']);
}
