<?php

namespace App\Helpers\RouteConstructor;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppleController;

class RouteConstructor
{
    public static $inertiaRoutes = [
        'apples' => AppleController::class
    ];

    public static function constructApiRoutes()
    {
        foreach (static::$inertiaRoutes as $route => $controller) {
            Route::apiResource($route, $controller);
            Route::delete("/api/$route", [$controller, 'destroyByFilter']);
            Route::patch("/api/$route", [$controller, 'updateByFilter']);
        }
    }

    public static function constructWebRoutes()
    {
        foreach (static::$inertiaRoutes as $route => $controller) {
            Route::resource($route, $controller, ['as' => 'web_' . $route]);
        }
    }
}
