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
Route::name('ppc.')->group(function () {

    Route::prefix('ppc/taskcard')->group(function() {
        Route::name('taskcard.')->group(function () {
            Route::resource('/type', 'TaskcardTypeController');
        });
    });

    // Route::prefix('ppc')->group(function() {
    //     Route::resource('/taskcard', 'TaskcardController');  

    //     Route::resource('/taskcard-group', 'TaskcardGroupController');

    //     Route::resource('/taskcard-workarea', 'TaskcardWorkareaController');

    //     Route::resource('/taskcard-access', 'TaskcardAccessController');

    //     Route::resource('/taskcard-zone', 'TaskcardZoneController');

    //     Route::resource('/taskcard-document-library', 'TaskcardDocumentLibraryController');

    //     Route::resource('/aircraft', 'AircraftController');
    // });
});  