<?php

use App\Http\Controllers\api\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AuthenticationController;

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

Route::controller(AuthenticationController::class)->group(function () {
    Route::post("/admin/login", "login");
    Route::get('/admin/checkAuthentication','checkIfAuthenticated')->middleware('auth:sanctum');
});

Route::group(
    ["prefix" => "admin", "middleware" => "auth:sanctum"],
    function () {
        Route::controller(DashboardController::class)->group(function () {
            Route::get("profile", "profile");
            Route::get('logout','logout');
        });

        Route::controller(\App\Http\Controllers\users\UserController::class,)->group(function (){
            Route::group(['prefix' => 'user'], function (){
                Route::get('index','index');
                Route::post('store','store');
                Route::get('edit/{user}','edit');
                Route::patch('update/{user}','update');
                Route::get('delete/{user}','delete');
            });
        });
    }
);
