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
Route::name('vaksinasi.')->group(function () {
    Route::prefix('vaksinasi')->group(function() {
        Route::resource('/squad', 'SquadController');   
        Route::name('squad.')->group(function() {
            Route::get('vaksinasi/squad/select2', 'SquadController@select2')->name('select2');
        });   
        
        Route::resource('/vaccination-participant', 'VaccinationParticipantController');

        Route::resource('/participant-daily', 'ParticipantDailyCountController');
    });
});