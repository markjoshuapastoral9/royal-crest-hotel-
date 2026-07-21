<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\RoomController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes – Monarch Hotel Booking System
|--------------------------------------------------------------------------
*/

// Public routes
Route::post('/register',    [AuthController::class, 'register']);
Route::post('/login',       [AuthController::class, 'login']);
Route::post('/verify-otp',  [AuthController::class, 'verifyOtp']);
Route::post('/resend-otp',  [AuthController::class, 'resendOtp']);

// Public room listing
Route::get('/rooms',        [RoomController::class, 'index']);
Route::get('/rooms/{room}', [RoomController::class, 'show']);

// Protected routes (requires Sanctum token)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user',     [AuthController::class, 'user']);
    Route::post('/logout',  [AuthController::class, 'logout']);

    // Bookings
    Route::get('/bookings',              [BookingController::class, 'index']);
    Route::post('/bookings',             [BookingController::class, 'store']);
    Route::get('/bookings/{booking}',    [BookingController::class, 'show']);
    Route::put('/bookings/{booking}',    [BookingController::class, 'update']);
    Route::delete('/bookings/{booking}', [BookingController::class, 'destroy']);
});
