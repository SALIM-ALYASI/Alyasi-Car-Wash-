<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BotController;
use App\Http\Controllers\AppointmentApiController;

Route::post('/clients', [BotController::class, 'storeClient']);
Route::get('/clients/{phone}', [BotController::class, 'getClient']);

Route::post('/appointments', [BotController::class, 'storeAppointment']);
Route::put('/appointments/{id}/status', [BotController::class, 'updateAppointmentStatus']);
Route::get('/appointments/available', [BotController::class, 'availableTimes']);

Route::post('/wash-status', [BotController::class, 'storeWashStatus']);
Route::get('/health', function() {
    return response()->json(['status' => 'ok']);
});

Route::get('/api/appointments', [AppointmentApiController::class, 'index']);
Route::get('/appointments/active', [BotController::class, 'getActiveAppointments']);

// 