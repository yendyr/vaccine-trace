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
Route::name('hr.')->group(function () {
    Route::prefix('hr')->group(function() {
        Route::get('/os/select2/orgcode', 'OrganizationStructureController@select2Orgcode')->name('os.select2.orgcode');
        Route::resource('/os', 'OrganizationStructureController');
        Route::get('/ost/select2/orgcode', 'OrganizationStructureTitleController@select2Orgcode')->name('ost.select2.orgcode');
        Route::get('/ost/select2/rptorg', 'OrganizationStructureTitleController@select2Rptorg')->name('ost.select2.rptorg');
        Route::get('/ost/select2/title', 'OrganizationStructureTitleController@select2Title')->name('ost.select2.title');
        Route::resource('/ost', 'OrganizationStructureTitleController');
    });
});

