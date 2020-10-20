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
        Route::get('/org-structure/select2/orglevel', 'OrganizationStructureController@select2Orglevel')->name('org-structure.select2.orglevel');
        Route::get('/org-structure/json', 'OrganizationStructureController@dataJson')->name('org-structure.json');
        Route::resource('/org-structure', 'OrganizationStructureController');

        Route::get('/org-structure-title/select2/titlecode', 'OrganizationStructureTitleController@select2Titlecode')->name('org-structure-title.select2.titlecode');
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
        Route::get('/employee/select2/maritalstatus', 'EmployeeController@select2Maritalstatus')->name('employee.select2.maritalstatus');
        Route::get('/employee/select2/bloodtype', 'EmployeeController@select2Bloodtype')->name('employee.select2.bloodtype');
        Route::get('/employee/select2/religion', 'EmployeeController@select2Religion')->name('employee.select2.religion');
        Route::resource('employee', 'EmployeeController');
        Route::get('/employee/select2/empid', 'EmployeeController@select2Empid')->name('employee.select2.empid');

        Route::resource('id-card', 'IdCardController');

        Route::get('/education/select2/edulvl', 'EducationController@select2Edulvl')->name('education.select2.edulvl');
        Route::resource('education', 'EducationController');

        Route::get('/family/select2/relationship', 'FamilyController@select2Relationship')->name('family.select2.relationship');
        Route::get('/family/select2/job', 'FamilyController@select2Job')->name('family.select2.job');
        Route::resource('family', 'FamilyController');
        Route::get('/address/select2/famid', 'AddressController@select2Famid')->name('address.select2.famid');

        Route::resource('address', 'AddressController');

        Route::get('/working-hour/select2/empid', 'WorkingHourController@select2Empid')->name('workhour.select2.empid');
        Route::get('working-hour/calculate', 'WorkingHourController@calculateIndex')->name('working-hour.calculate');
        Route::resource('working-hour', 'WorkingHourController');

        Route::resource('working-hour-detail', 'WorkingHourDetailController');

        Route::resource('working-hour-attendance', 'WorkingHourAttendanceController');

        Route::get('/attendance/select2/type', 'AttendanceController@select2Type')->name('attendance.select2.type');
        Route::get('/attendance/validate', 'AttendanceController@validationView')->name('attendance.validate');
        Route::post('/attendance/validate', 'AttendanceController@validateAll')->name('attendance.validate');
        Route::get('/attendance/datatable', 'AttendanceController@datatableInOut')->name('attendance.datatable');
        Route::get('/attendance/import', 'AttendanceController@index')->name('attendance.import');
        Route::resource('attendance', 'AttendanceController');
    });
});

