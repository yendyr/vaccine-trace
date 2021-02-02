<?php

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
Route::name('flightoperations.')->group(function () {
    Route::prefix('flightoperations')->group(function () {
        
        Route::resource('/maintenance-log', 'MaintenanceLogController');

        Route::resource('/flight-log', 'FlightLogController');
    });
});