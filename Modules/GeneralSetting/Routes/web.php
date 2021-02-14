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
        Route::name('country.')->group(function() {
            Route::get('generalsetting/country/select2', 'CountryController@select2')->name('select2');
        });

        Route::resource('/airport', 'AirportController');
        Route::name('airport.')->group(function() {
            Route::get('generalsetting/airport/select2', 'AirportController@select2')->name('select2');
        });

        Route::resource('/company', 'CompanyController');
        Route::name('company.')->group(function() {
            Route::get('generalsetting/company/select2/customer', 'CompanyController@select2Customer')->name('select2.customer');
            Route::get('generalsetting/company/select2/supplier', 'CompanyController@select2Supplier')->name('select2.supplier');
            Route::get('generalsetting/company/select2/manufacturer', 'CompanyController@select2Manufacturer')->name('select2.manufacturer');
            Route::get('generalsetting/company/select2/company', 'CompanyController@select2Company')->name('select2.company');

            Route::post('/company/logo-upload/{company}', 'CompanyController@logoUpload')->name('logo-upload');
        });

        Route::resource('/company-detail-contact', 'CompanyDetailContactController');
        Route::resource('/company-detail-address', 'CompanyDetailAddressController');
        Route::resource('/company-detail-bank', 'CompanyDetailBankController');        
    });
});