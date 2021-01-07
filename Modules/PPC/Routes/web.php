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
        
        Route::resource('/taskcard-type', 'TaskcardTypeController');
        Route::get('/taskcard-type/create', 'TaskcardTypeController@create');

        Route::resource('/taskcard-workarea', 'TaskcardWorkareaController');
        Route::get('/taskcard-workarea/create', 'TaskcardWorkareaController@create');

        Route::resource('/taskcard-access', 'TaskcardAccessController');
        Route::get('/taskcard-access/create', 'TaskcardAccessController@create');

        Route::resource('/taskcard-zone', 'TaskcardZoneController');
        Route::get('/taskcard-zone/create', 'TaskcardZoneController@create');

        Route::resource('/taskcard-document-library', 'TaskcardDocumentLibraryController');
        Route::get('/taskcard-document-library/create', 'TaskcardDocumentLibraryController@create');

        Route::resource('/aircraft', 'AircraftController');
        Route::get('/aircraft/create', 'Aircraft@create');
    });
});  