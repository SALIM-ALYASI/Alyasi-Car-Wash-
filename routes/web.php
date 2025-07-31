<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController; 
use App\Http\Controllers\WashController;
 

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
 

Route::get('/dashboard/add', [DashboardController::class, 'addAppointment'])->name('add_appointment');
Route::post('/dashboard/add', [DashboardController::class, 'storeAppointment'])->name('store_appointment');
 
Route::get('/wash/start/{id}', [WashController::class, 'start'])->name('wash.start');
Route::post('/wash/start/{id}/verify', [WashController::class, 'verify'])->name('wash.verify');

Route::post('/wash/start/{id}/invoice', [WashController::class, 'sendInvoice'])->name('wash.invoice');
Route::get('/invoice/{id}', [WashController::class, 'showInvoice'])->name('wash.invoice.show');
