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
Route::name('accounting.')->group(function () {
    Route::prefix('accounting')->group(function() {
        Route::resource('/chart-of-account-class', 'ChartOfAccountClassController');
        Route::name('chart-of-account-class.')->group(function() {
            Route::get('accounting/chart-of-account-class/select2', 'ChartOfAccountClassController@select2')->name('select2');
        });

        Route::resource('/chart-of-account', 'ChartOfAccountController');
        Route::name('chart-of-account.')->group(function() {
            Route::get('accounting/chart-of-account/select2/parent', 'ChartOfAccountController@select2Parent')->name('select2.parent');
            Route::get('accounting/chart-of-account/select2/child', 'ChartOfAccountController@select2Child')->name('select2.child');
        });
    });
}); 