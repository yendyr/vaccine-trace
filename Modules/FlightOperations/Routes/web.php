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

        Route::name('in-flight-role.')->group(function() {
            Route::get('in-flight-role', [Modules\Gate\Http\Controllers\RoleController::class, 'index_flightoperations'])->name('index');
            Route::patch('in-flight-role/{role}', [Modules\Gate\Http\Controllers\RoleController::class, 'update_flightoperations'])->name('update');
        });
        
        Route::resource('/afmlog', 'AfmLogController');
        Route::post('/afmlog/{afmlog}/approve', 'AfmLogController@approve');

        Route::resource('/afml-detail-crew', 'AfmlDetailCrewController');

        Route::resource('/afml-detail-journal', 'AfmlDetailJournalController');

        Route::resource('/afml-detail-manifest', 'AfmlDetailManifestController');

        Route::resource('/afml-detail-discrepancy', 'AfmlDetailDiscrepancyController');
        Route::name('afml.')->group(function() {
            Route::get('flightoperations/afml-detail-discrepancy/select2', 'AfmlDetailDiscrepancyController@select2')->name('discrepancy.select2');
        });

        Route::resource('/afml-detail-rectification', 'AfmlDetailRectificationController');
    });
});