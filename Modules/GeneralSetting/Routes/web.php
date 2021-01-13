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

Route::name('generalsetting.')->group(function () {
    Route::prefix('generalsetting')->group(function() {
        Route::resource('/country', 'CountryController');
        Route::resource('/company', 'CompanyController');
        Route::resource('/airport', 'AirportController');

        Route::name('company.')->group(function() {
            Route::get('generalsetting/company/select2/customer', 'CompanyController@select2Customer')->name('select2.customer');
            Route::get('generalsetting/company/select2/supplier', 'CompanyController@select2Supplier')->name('select2.supplier');
            Route::get('generalsetting/company/select2/manufacturer', 'CompanyController@select2Manufacturer')->name('select2.manufacturer');
        });

    });
});