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
        Route::resource('/taskcard', 'TaskcardController');
        Route::get('/taskcard/create', 'TaskcardController@create');  

        Route::resource('/taskcard-group', 'TaskcardGroupController');
        Route::get('/taskcard-group/create', 'TaskcardGroupController@create');
        
        Route::resource('/taskcard/type', 'TaskcardTypeController');

        Route::resource('/taskcard-workarea', 'TaskcardWorkareaController');

        Route::resource('/taskcard-access', 'TaskcardAccessController');

        Route::resource('/taskcard-zone', 'TaskcardZoneController');

        Route::resource('/taskcard-document-library', 'TaskcardDocumentLibraryController');

        Route::resource('/aircraft', 'AircraftController');
    });
});  