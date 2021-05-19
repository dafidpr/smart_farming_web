<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\GuideController;

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
        Route::post('{id}/update', [RoleController::class, 'update'])->middleware('can:update-roles');
        Route::delete('{id}/delete', [RoleController::class, 'destroy'])->middleware('can:delete-roles');
        Route::delete('multipleDelete', [RoleController::class, 'multipleDelete'])->middleware('can:delete-roles');
        Route::post('{id}/change-permission', [RoleController::class, 'changePermission'])->middleware('can:update-roles');
    });

    // Permissions
    Route::prefix('permissions')->group(function () {
        Route::get('', [PermissionController::class, 'index'])->middleware('can:read-permissions');
        Route::post('store', [PermissionController::class, 'store'])->middleware('can:create-permissions');
        Route::delete('{id}/delete', [PermissionController::class, 'destroy'])->middleware('can:delete-permissions')->name('permission.destroy');
        Route::delete('multipleDelete', [PermissionController::class, 'multipleDelete'])->middleware('can:delete-permissions')->name('permission.bulk-destroy');
    });

    // Settings
    Route::prefix('settings')->group(function () {
        Route::get('', [SettingController::class, 'index'])->middleware('can:read-settings');
        Route::get('{id}/edit', [SettingController::class, 'edit'])->middleware('can:update-settings');
        Route::post('{id}/update', [SettingController::class, 'update'])->middleware('can:update-settings');
        Route::post('{id}/maintenance', [SettingController::class, 'maintenanceMode'])->middleware('can:update-settings');
    });
});
