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

    });
});