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
    Route::prefix('ppc')->group(function () {
        Route::resource('/taskcard-type', 'TaskcardTypeController');
        Route::name('taskcard-type.')->group(function () {
            Route::get('ppc/taskcard-type/select2', 'TaskcardTypeController@select2')->name('select2');
        });

        Route::get('/taskcard-group/detail-tree', 'TaskcardGroupController@tree')->name('taskcard-group.detail-tree');

        Route::resource('/taskcard-group', 'TaskcardGroupController');
        Route::name('taskcard-group.')->group(function () {
            Route::get('ppc/taskcard-group/select2/parent', 'TaskcardGroupController@select2Parent')->name('select2.parent');
            Route::get('ppc/taskcard-group/select2/child', 'TaskcardGroupController@select2Child')->name('select2.child');
        });

        Route::resource('/taskcard-tag', 'TaskcardTagController');
        Route::name('taskcard-tag.')->group(function () {
            Route::get('ppc/taskcard-tag/select2/parent', 'TaskcardTagController@select2')->name('select2');
        });

        Route::resource('/taskcard-workarea', 'TaskcardWorkareaController');
        Route::name('taskcard-workarea.')->group(function () {
            Route::get('ppc/taskcard-workarea/select2', 'TaskcardWorkareaController@select2')->name('select2');
        });

        Route::resource('/taskcard-access', 'TaskcardAccessController');
        Route::name('taskcard-access.')->group(function () {
            Route::get('ppc/taskcard-access/select2', 'TaskcardAccessController@select2')->name('select2');
        });

        Route::resource('/taskcard-zone', 'TaskcardZoneController');
        Route::name('taskcard-zone.')->group(function () {
            Route::get('ppc/taskcard-zone/select2', 'TaskcardZoneController@select2')->name('select2');
        });

        Route::resource('/taskcard-document-library', 'TaskcardDocumentLibraryController');
        Route::name('taskcard-document-library.')->group(function () {
            Route::get('ppc/taskcard-document-library/select2', 'TaskcardDocumentLibraryController@select2')->name('select2');
        });

        Route::resource('/aircraft-type', 'AircraftTypeController');
        Route::name('aircraft-type.')->group(function () {
            Route::get('ppc/aircraft-type/select2', 'AircraftTypeController@select2')->name('select2');
        });

        Route::name('taskcard.')->group(function () {
            Route::patch('/taskcard/update-control-parameter/{taskcard}', 'TaskcardController@updateControlParameter')->name('updateControlParameter');
        });
        Route::resource('/taskcard', 'TaskcardController');
        Route::name('taskcard.')->group(function () {
            Route::post('/taskcard/file-upload/{taskcard}', 'TaskcardController@fileUpload')->name('file-upload');
        });

        Route::get('/taskcard-detail-instruction/detail-tree', 'TaskcardDetailInstructionController@tree')->name('taskcard-detail-instruction.detail-tree');

        Route::resource('/taskcard-detail-instruction', 'TaskcardDetailInstructionController');
        Route::name('taskcard-detail-instruction.')->group(function () {
            Route::get('ppc/taskcard-detail-instruction/select2/parent', 'TaskcardDetailInstructionController@select2Parent')->name('select2.parent');
            // Route::get('ppc/taskcard-group/select2/child', 'TaskcardGroupController@select2Child')->name('select2.child');
        });

        Route::resource('/taskcard-detail-item', 'TaskcardDetailItemController');

        Route::name('maintenance-program.')->prefix('maintenance-program')->group(function () {
            Route::get('/select2', 'MaintenanceProgramController@select2')->name('select2');
        });
        Route::resource('/maintenance-program', 'MaintenanceProgramController');

        Route::name('maintenance-program.')->prefix('maintenance-program/{MaintenanceProgram}')->group(function () {
            Route::post('/use-all-taskcard', 'MaintenanceProgramDetailController@useAll')->name('use-all-taskcard');
        });
        Route::resource('/maintenance-program-detail', 'MaintenanceProgramDetailController');

        Route::get('/aircraft-configuration-template/detail-tree', 'AircraftConfigurationTemplateDetailController@tree')->name('aircraft-configuration-template.detail-tree');

        Route::resource('/aircraft-configuration-template', 'AircraftConfigurationTemplateController');
        Route::name('aircraft-configuration-template.')->group(function () {
            Route::get('ppc/aircraft-configuration-template/select2', 'AircraftConfigurationTemplateController@select2')->name('select2');
        });

        Route::resource('/configuration-template-detail', 'AircraftConfigurationTemplateDetailController');
        Route::name('configuration-template-detail.')->group(function () {
            Route::get('ppc/configuration-template-detail/select2', 'AircraftConfigurationTemplateDetailController@select2Parent')->name('select2');
        });

        Route::get('/aircraft-configuration/detail-tree', 'AircraftConfigurationDetailController@tree')->name('aircraft-configuration.detail-tree');

        Route::resource('/aircraft-configuration', 'AircraftConfigurationController');
        Route::name('aircraft-configuration.')->group(function () {
            Route::get('ppc/aircraft-configuration/select2', 'AircraftConfigurationController@select2')->name('select2');
        });
        Route::post('/aircraft-configuration/{aircraft_configuration}/approve', 'AircraftConfigurationController@approve');

        Route::resource('/configuration-detail', 'AircraftConfigurationDetailController');
        Route::name('configuration-detail.')->group(function () {
            Route::get('ppc/configuration-detail/select2', 'AircraftConfigurationDetailController@select2Parent')->name('select2');
        });

        Route::resource('/item-aging-report', 'ItemStockAgingController');
        Route::resource('/aircraft-aging-report', 'AircraftAgingController');
        Route::resource('/maintenance-status-report', 'MaintenanceStatusController');

        Route::name('work-order.')->prefix('work-order')->group(function () {
            Route::get('/select2/aircraft', 'WorkOrderController@select2Aircraft')->name('select2.aircraft');
            Route::get('/select2/work-order', 'WorkOrderController@select2')->name('select2');
            Route::post('/{work_order}/file-upload', 'WorkOrderController@fileUpload')->name('file-upload');
            Route::post('/{work_order}/approve', 'WorkOrderController@approve')->name('approve');
            Route::get('/{work_order}/item-requirements-summary', 'WorkOrderController@itemRequirements')->name('item-requirements-summary');
            Route::get('/{work_order}/aircraft-maintenance-program', 'WorkOrderController@aircraftMaintenanceProgram')->name('aircraft-maintenance-program');
            
            Route::name('work-package.')->prefix('{work_order}/work-package/{work_package}')->group(function () {
                
                Route::post('/use-all-taskcard', 'WorkOrderWorkPackageController@useAll')->name('use-all-taskcard');
                Route::post('/aircraft-maintenance-program/use-all-taskcard', 'WorkOrderWorkPackageController@useAllMaintenanceProgram')->name('aircraft-maintenance-program.use-all-taskcard');
                Route::get('/item-requirements-summary', 'WorkOrderWorkPackageController@itemRequirements')->name('item-requirements-summary');
                Route::get('/item', 'WOWPTaskcardDetailItemController@index')->name('item.index');

                Route::name('taskcard.')->prefix('taskcard/{taskcard}')->group(function () {
                    Route::get('tree', 'WorkOrderWorkPackageTaskcardController@tree')->name('tree');
                    Route::resource('item', 'WOWPTaskcardDetailItemController')->except(['index']);
                });

                Route::resource('taskcard', 'WorkOrderWorkPackageTaskcardController');

            });

            Route::resource('{work_order}/work-package', 'WorkOrderWorkPackageController');

        });

        Route::name('job-card.')->prefix('job-card')->group(function () {
            Route::get('/generate', 'JobCardController@generate')->name('generate.index');
            Route::get('/print', 'JobCardController@print')->name('print');
            Route::post('/execute', 'JobCardController@execute')->name('execute');
            Route::patch('/{job_card}/release', 'JobCardController@release')->name('release');
            Route::post('/{work_order}/generate', 'WorkOrderController@generate')->name('generate');
        });

        Route::resource('/work-order', 'WorkOrderController');
        Route::resource('job-card', 'JobCardController');
    });
});
