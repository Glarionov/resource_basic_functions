<?php

namespace App\Helpers\RouteConstructor;

use App\Http\Controllers\OrganizationsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppleController;

class RouteConstructor
{
    public static $inertiaRoutes = [
        'apples' => AppleController::class
    ];

    public static function constructApiRoutes()
    {

//        Route::put('/apples-list', [\App\Http\Controllers\AppleController::class, 'updateByFilter'])
//    ->name('organizations.apples');

        foreach (static::$inertiaRoutes as $route => $controller) {
//            Route::apiResource($route, $controller);
            Route::delete("/$route", [$controller, 'destroyByFilter']);
            Route::put("/$route", [$controller, 'updateByFilter']);
//            Route::put("/$route-list", [OrganizationsController::class, 'update']);//todo r
        }
    }

    public static function constructWebRoutes()
    {
//        Route::put('/api/apples-list', [\App\Http\Controllers\AppleController::class, 'updateByFilter'])
//            ->name('organizations.apples');

        foreach (static::$inertiaRoutes as $route => $controller) {
//            Route::put('/api/apples-list', [\App\Http\Controllers\AppleController::class, 'updateByFilter'])
//                ->name('organizations.apples');
//            Route::apiResource($route, $controller);
//            Route::delete("/api/$route", [$controller, 'destroyByFilter']);
//            Route::put("/api/$route", [$controller, 'updateByFilter']);

            Route::apiResource( "/api/" . $route, $controller);
            Route::delete("/api/$route", [$controller, 'destroyByFilter']);
            Route::put("/api/$route", [$controller, 'updateByFilter']);
            Route::resource($route, $controller, ['as' => 'web_' . $route]);

////            Route::put("/$route-list", [OrganizationsController::class, 'update']);//todo r
        }
//
//        foreach (static::$inertiaRoutes as $route => $controller) {
//            Route::resource($route, $controller, ['as' => 'web_' . $route]);
//        }
    }
}
