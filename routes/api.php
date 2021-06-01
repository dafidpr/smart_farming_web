<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ControlController;
use App\Http\Controllers\API\FarmerController;
use App\Http\Controllers\API\SensorController;
use App\Http\Controllers\API\SensorHistoryController;
use App\Http\Controllers\API\FarmerGroupController;
use App\Http\Controllers\API\ScheduleController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/logout', [AuthController::class, 'logout']); //done
    Route::get('/sensor-histories/{serial_number}/getSensorHistory', [SensorHistoryController::class, 'getSensorHistory']); //done
    Route::get('/sensor/{serial_number}/getTemperatureHumidity', [SensorController::class, 'getTemperatureHumidity']); //done
    Route::post('/farmers/{id}/update', [FarmerController::class, 'update']);
    Route::post('/farmers/change-password', [AuthController::class, 'updatePassword']);
    Route::post('/lamp-status-update', [ControlController::class, 'lampStatusUpdate']); //done
    Route::post('/get-lamp-status-for-mobile', [ControlController::class, 'getStatus']);
});
Route::post('/login', [AuthController::class, 'postLogin']); // done
Route::post('/register', [AuthController::class, 'registerFarmer']); // done
Route::get('/farmer-groups', [FarmerGroupController::class, 'getFarmerGroup']); // done
Route::post('/sensore-store', [SensorController::class, 'store']); // done
Route::post('/get-lamp-status-for-arduino', [ControlController::class, 'getStatus']); //done
Route::get('/schedule/{serial_number}/get-schedule-for-arduino', [ScheduleController::class, 'getSchedule']);
