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
        Route::get('/workgroup-detail/select2/shiftno', 'WorkingGroupDetailController@select2Shiftno')->name('workgroup-detail.select2.shiftno');
        Route::resource('/workgroup-detail', 'WorkingGroupDetailController');

        Route::get('/holiday/select2/code', 'HolidayController@select2Code')->name('holiday.select2.code');
        Route::get('/holiday/select2/year', 'HolidayController@select2Year')->name('holiday.select2.year');
        Route::post('/holiday/sundays', 'HolidayController@generateSundays')->name('holiday.sundays');
        Route::resource('holiday', 'HolidayController');

        Route::get('/employee/select2/orgcode', 'EmployeeController@select2Orgcode')->name('employee.select2.orgcode');
        Route::get('/employee/select2/title', 'EmployeeController@select2Title')->name('employee.select2.title');
        Route::get('/employee/select2/jobtitle', 'EmployeeController@select2Jobtitle')->name('employee.select2.jobtitle');
        Route::get('/employee/select2/orglvl', 'EmployeeController@select2Orglvl')->name('employee.select2.orglvl');
        Route::get('/employee/select2/recruitby', 'EmployeeController@select2Recruitby')->name('employee.select2.recruitby');
        Route::resource('employee', 'EmployeeController');

        Route::get('/id-card/select2/empid', 'IdCardController@select2Empid')->name('id-card.select2.empid');
        Route::resource('id-card', 'IdCardController');
    });
});

