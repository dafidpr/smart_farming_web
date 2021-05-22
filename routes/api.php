<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\FarmerController;
use App\Http\Controllers\API\SensorController;
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
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/farmer/getFarmer', [FarmerController::class, 'getFarmer']);
    Route::patch('/farmer/{id}/update', [FarmerController::class, 'update']);
    Route::patch('/farmer/change-password', [AuthController::class, 'updatePassword']);
});
Route::post('/login', [AuthController::class, 'postLogin']);
Route::post('/register', [AuthController::class, 'registerFarmer']);
Route::post('/sensore-store', [SensorController::class, 'store']);
