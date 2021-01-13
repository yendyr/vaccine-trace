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
    Route::prefix('ppc')->group(function() {
        Route::resource('/taskcard-type', 'TaskcardTypeController');
        Route::name('taskcard-type.')->group(function() {
            Route::get('ppc/taskcard-type/select2', 'TaskcardTypeController@select2')->name('select2');
        });

        Route::resource('/taskcard-group', 'TaskcardGroupController');
        Route::name('taskcard-group.')->group(function() {
            Route::get('ppc/taskcard-group/select2/parent', 'TaskcardGroupController@select2Parent')->name('select2.parent');
            Route::get('ppc/taskcard-group/select2/child', 'TaskcardGroupController@select2Child')->name('select2.child');
        });

        Route::resource('/taskcard-workarea', 'TaskcardWorkareaController');
        Route::resource('/taskcard-access', 'TaskcardAccessController');
        Route::resource('/taskcard-zone', 'TaskcardZoneController');
        Route::resource('/taskcard-document-library', 'TaskcardDocumentLibraryController');
        Route::resource('/taskcard', 'TaskcardController');

        Route::resource('/aircraft-type', 'AircraftTypeController');
    });
}); 