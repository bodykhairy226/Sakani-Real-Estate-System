<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\AmenityController;
use App\Http\Controllers\Api\PropertyController;
use App\Http\Controllers\Api\PropertyImageController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\NeedRequestController;
use App\Http\Controllers\Api\ContactMessageController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\PropertyTypeController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\StatisticsController;
use App\Http\Controllers\Api\CloudinaryController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::post('/login', [AuthController::class, 'login']);
Route::post('/login-status', [AuthController::class, 'loginStatus']);
Route::post('/contact-messages', [ContactMessageController::class, 'store']);
Route::post('/reservations', [ReservationController::class, 'store']);
Route::get('/properties', [PropertyController::class, 'index']);
Route::get('/properties/{property}', [PropertyController::class, 'show']);
Route::get('/properties/category/{category}', [PropertyController::class, 'byCategory']);
Route::post('/need-requests', [NeedRequestController::class, 'store']);
/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('locations', LocationController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('amenities', AmenityController::class);
    Route::post('/properties', [PropertyController::class, 'store']);
Route::put('/properties/{property}', [PropertyController::class, 'update']);
Route::delete('/properties/{property}', [PropertyController::class, 'destroy']);
    Route::apiResource('property-images', PropertyImageController::class);
    Route::apiResource('reservations', ReservationController::class)
    ->except(['store']);
    Route::apiResource('need-requests', NeedRequestController::class)
    ->except(['store']);
    Route::apiResource('contact-messages', ContactMessageController::class)->except(['store']);
    Route::apiResource('settings', SettingController::class);
    Route::apiResource('property-types', PropertyTypeController::class);
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/statistics', [StatisticsController::class, 'index']);
    Route::post('/cloudinary/signature', [CloudinaryController::class, 'signature']);
Route::put('/admin/credentials', [AuthController::class, 'updateCredentials']);
});