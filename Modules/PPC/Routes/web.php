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

        Route::get('/taskcard-group/detail-tree', 'TaskcardGroupController@tree')->name('taskcard-group.detail-tree');

        Route::resource('/taskcard-group', 'TaskcardGroupController');
        Route::name('taskcard-group.')->group(function() {
            Route::get('ppc/taskcard-group/select2/parent', 'TaskcardGroupController@select2Parent')->name('select2.parent');
            Route::get('ppc/taskcard-group/select2/child', 'TaskcardGroupController@select2Child')->name('select2.child');
        });

        Route::resource('/taskcard-workarea', 'TaskcardWorkareaController');
        Route::name('taskcard-workarea.')->group(function() {
            Route::get('ppc/taskcard-workarea/select2', 'TaskcardWorkareaController@select2')->name('select2');
        });

        Route::resource('/taskcard-access', 'TaskcardAccessController');
        Route::name('taskcard-access.')->group(function() {
            Route::get('ppc/taskcard-access/select2', 'TaskcardAccessController@select2')->name('select2');
        });

        Route::resource('/taskcard-zone', 'TaskcardZoneController');
        Route::name('taskcard-zone.')->group(function() {
            Route::get('ppc/taskcard-zone/select2', 'TaskcardZoneController@select2')->name('select2');
        });

        Route::resource('/taskcard-document-library', 'TaskcardDocumentLibraryController');
        Route::name('taskcard-document-library.')->group(function() {
            Route::get('ppc/taskcard-document-library/select2', 'TaskcardDocumentLibraryController@select2')->name('select2');
        });
        
        Route::resource('/aircraft-type', 'AircraftTypeController');
        Route::name('aircraft-type.')->group(function() {
            Route::get('ppc/aircraft-type/select2', 'AircraftTypeController@select2')->name('select2');
        });

        Route::resource('/taskcard', 'TaskcardController');
        Route::name('taskcard.')->group(function() {
            Route::post('/taskcard/file-upload/{taskcard}', 'TaskcardController@fileUpload')->name('file-upload');
        });

        Route::resource('/taskcard-detail-instruction', 'TaskcardDetailInstructionController');

        Route::resource('/taskcard-detail-item', 'TaskcardDetailItemController');

        Route::get('/aircraft-configuration-template/detail-tree', 'AircraftConfigurationTemplateDetailController@tree')->name('aircraft-configuration-template.detail-tree');

        Route::resource('/aircraft-configuration-template', 'AircraftConfigurationTemplateController');
        Route::name('aircraft-configuration-template.')->group(function() {
            Route::get('ppc/aircraft-configuration-template/select2', 'AircraftConfigurationTemplateController@select2')->name('select2');
        });

        Route::resource('/configuration-template-detail', 'AircraftConfigurationTemplateDetailController');        
        Route::name('configuration-template-detail.')->group(function() {
            Route::get('ppc/configuration-template-detail/select2', 'AircraftConfigurationTemplateDetailController@select2Parent')->name('select2');
        });

        Route::get('/aircraft-configuration/detail-tree', 'AircraftConfigurationDetailController@tree')->name('aircraft-configuration.detail-tree');

        Route::resource('/aircraft-configuration', 'AircraftConfigurationController');
        Route::name('aircraft-configuration.')->group(function() {
            Route::get('ppc/aircraft-configuration/select2', 'AircraftConfigurationController@select2')->name('select2');
        });
        Route::post('/aircraft-configuration/{aircraft_configuration}/approve', 'AircraftConfigurationController@approve');

        Route::resource('/configuration-detail', 'AircraftConfigurationDetailController');        
        Route::name('configuration-detail.')->group(function() {
            Route::get('ppc/configuration-detail/select2', 'AircraftConfigurationDetailController@select2Parent')->name('select2');
        });

        // Route::resource('/maintenance-program', 'MaintenanceProgramController');
    });
}); 