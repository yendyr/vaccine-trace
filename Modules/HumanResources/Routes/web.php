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
        Route::get('/org-structure/select2/orgcode', 'OrganizationStructureController@select2Orgcode')->name('org-structure.select2.orgcode');
        Route::get('/org-structure/json', 'OrganizationStructureController@dataJson')->name('org-structure.json');
        Route::resource('/org-structure', 'OrganizationStructureController');

        Route::get('/org-structure-title/select2/orgcode', 'OrganizationStructureTitleController@select2Orgcode')->name('org-structure-title.select2.orgcode');
        Route::get('/org-structure-title/select2/rptorg', 'OrganizationStructureTitleController@select2Rptorg')->name('org-structure-title.select2.rptorg');
        Route::get('/org-structure-title/select2/title', 'OrganizationStructureTitleController@select2Title')->name('org-structure-title.select2.title');
        Route::resource('/org-structure-title', 'OrganizationStructureTitleController');

        Route::resource('/workgroup', 'WorkingGroupController');

        Route::get('/workgroup-detail/select2/workgroup', 'WorkingGroupDetailController@select2Workgroup')->name('workgroup-detail.select2.workgroup');
        Route::resource('/workgroup-detail', 'WorkingGroupDetailController');

    });
});

