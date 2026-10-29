<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SalonController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\ReservationController;

Route::apiResource('salons', SalonController::class);

Route::get('/salons/{salon}/services', [ServiceController::class, 'bySalon'])
    ->name('salons.services.index');

Route::apiResource('services', ServiceController::class);

Route::apiResource('reservations', ReservationController::class);