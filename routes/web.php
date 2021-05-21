<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\DeviceController;
use App\Http\Controllers\Admin\FarmerController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\FarmerGroupController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route Auth
Route::group(['middleware' => ['auth.logout_only']], function () {

    Route::get('/', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'postLogin']);
});

Route::get('/logout', [AuthController::class, 'logout']);


// Route Administrator
Route::prefix('administrator')->middleware(['auth.login_only', 'maintenance_mode', 'user_block_status'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('can:read-dashboard');

    // User
    Route::prefix('users')->group(function () {
        Route::get('', [UserController::class, 'index'])->middleware('can:read-users');
        Route::get('create', [UserController::class, 'create'])->middleware('can:create-users');
        Route::post('store', [UserController::class, 'store'])->middleware('can:create-users');
        Route::get('{id}/edit', [UserController::class, 'edit'])->middleware('can:update-users');
        Route::get('{id}/detail', [UserController::class, 'show']);
        Route::post('{id}/block', [UserController::class, 'blockUser'])->middleware('can:update-users');
        Route::post('{id}/update', [UserController::class, 'update'])->middleware('can:update-users');
        Route::delete('{id}/delete', [UserController::class, 'destroy'])->middleware('can:delete-users');
        Route::delete('multipleDelete', [UserController::class, 'multipleDelete'])->middleware('can:delete-users');
        Route::get('change_password', [UserController::class, 'changePassword']);
        Route::post('change_password/update_password', [UserController::class, 'updatePassword']);
    });

    // Role
    Route::prefix('roles')->group(function () {
        Route::get('', [RoleController::class, 'index'])->middleware('can:read-roles');
        Route::get('{id}/changes', [RoleController::class, 'edit'])->middleware('can:update-roles');
        Route::post('store', [RoleController::class, 'store'])->middleware('can:create-roles');
        Route::post('{id}/update', [RoleController::class, 'update'])->middleware('can:update-roles');
        Route::get('{id}/show', [RoleController::class, 'show'])->middleware('can:update-roles');
        Route::delete('{id}/delete', [RoleController::class, 'destroy'])->middleware('can:delete-roles');
        Route::delete('multipleDelete', [RoleController::class, 'multipleDelete'])->middleware('can:delete-roles');
        Route::post('{id}/change-permission', [RoleController::class, 'changePermission'])->middleware('can:update-roles');
    });

    // Device
    Route::prefix('devices')->group(function () {
        Route::get('', [DeviceController::class, 'index'])->middleware('can:read-devices');
        Route::post('store', [DeviceController::class, 'store'])->middleware('can:create-devices');
        Route::post('{id}/update', [DeviceController::class, 'update'])->middleware('can:update-devices');
        Route::get('{id}/show', [DeviceController::class, 'show'])->middleware('can:update-devices');
        Route::post('{id}/update', [DeviceController::class, 'update'])->middleware('can:update-devices');
        Route::delete('{id}/delete', [DeviceController::class, 'destroy'])->middleware('can:delete-devices');
        Route::delete('multipleDelete', [DeviceController::class, 'multipleDelete'])->middleware('can:delete-devices');
    });

    // Farmer Groups
    Route::prefix('farmer-groups')->group(function () {
        Route::get('', [FarmerGroupController::class, 'index'])->middleware('can:read-farmer-groups');
        Route::get('create', [FarmerGroupController::class, 'create'])->middleware('can:create-farmer-groups');
        Route::post('store', [FarmerGroupController::class, 'store'])->middleware('can:create-farmer-groups');
        Route::get('{id}/edit', [FarmerGroupController::class, 'edit'])->middleware('can:update-farmer-groups');
        Route::post('{id}/update', [FarmerGroupController::class, 'update'])->middleware('can:update-farmer-groups');
        Route::delete('{id}/delete', [FarmerGroupController::class, 'destroy'])->middleware('can:delete-farmer-groups')->name('farmer-group.destroy');
        Route::delete('multipleDelete', [FarmerGroupController::class, 'multipleDelete'])->middleware('can:delete-farmer-groups')->name('farmer-group.bulk-destroy');
    });

    // Mappings
    Route::prefix('mappings')->group(function () {
        Route::get('', [FarmerGroupController::class, 'mapping'])->middleware('can:read-mappings');
        Route::get('getDataMap', [FarmerGroupController::class, 'getDataMap']);
    });

    // Farmers
    Route::prefix('farmers')->group(function () {
        Route::get('', [FarmerController::class, 'index'])->middleware('can:read-farmers');
        Route::get('create', [FarmerController::class, 'create'])->middleware('can:create-farmers');
        Route::post('store', [FarmerController::class, 'store'])->middleware('can:create-farmers');
        Route::get('{id}/edit', [FarmerController::class, 'edit'])->middleware('can:update-farmers');
        Route::post('{id}/update', [FarmerController::class, 'update'])->middleware('can:update-farmers');
        Route::delete('{id}/delete', [FarmerController::class, 'destroy'])->middleware('can:delete-farmers')->name('farmers.destroy');
        Route::delete('multipleDelete', [FarmerController::class, 'multipleDelete'])->middleware('can:delete-farmers')->name('farmers.bulk-destroy');
        Route::post('{id}/block', [FarmerController::class, 'blockFarmer'])->middleware('can:update-farmers');
        Route::post('{id}/approve', [FarmerController::class, 'approve'])->middleware('can:update-farmers');
        Route::post('{id}/reject', [FarmerController::class, 'reject'])->middleware('can:update-farmers');
    });

    // Settings
    Route::prefix('settings')->group(function () {
        Route::get('', [SettingController::class, 'index'])->middleware('can:read-settings');
        Route::get('{id}/edit', [SettingController::class, 'edit'])->middleware('can:update-settings');
        Route::post('{id}/update', [SettingController::class, 'update'])->middleware('can:update-settings');
        Route::post('{id}/maintenance', [SettingController::class, 'maintenanceMode'])->middleware('can:update-settings');
    });
});
