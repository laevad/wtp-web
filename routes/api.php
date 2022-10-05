<?php

use App\Http\Controllers\Api\ApiIncentiveController;
use App\Http\Controllers\Api\ApiMarkerController;
use App\Http\Controllers\Api\ApiTripController;
use App\Http\Controllers\Api\ApiUserController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'api', 'prefix' => 'auth'],function () {
    Route::post('login', [AuthController::class,"login"])->name("login");
    Route::get('me', [AuthController::class,"me"])->name("me");
    Route::post('logout', [AuthController::class,"logout"]);
});
Route::group(['middleware' => 'api.auth', 'prefix' => 'user'],function () {
    Route::post('update',[ApiUserController::class, 'updateProfile']);
    Route::post('location',[ApiUserController::class, 'addLocation']);
});
Route::group(['middleware' => 'api.auth', 'prefix' => 'trip'],function () {
    Route::get('trip',[ApiTripController::class, 'trip']);
    Route::post('status',[ApiTripController::class, 'updateTripStatus']);
});
Route::group(['middleware' => 'api.auth', 'prefix' => 'incentive'],function () {
    Route::get('incentive',[ApiIncentiveController::class, 'incentive']);
});

Route::group(['middleware' => 'api.auth', 'prefix' => 'marker'],function () {
    Route::post('marker',[ApiMarkerController::class, 'marker']);
});
