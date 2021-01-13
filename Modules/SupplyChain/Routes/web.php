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
Route::name('supplychain.')->group(function () {
    Route::prefix('supplychain')->group(function() {
        Route::resource('/warehouse', 'WarehouseController');
        Route::name('warehouse.')->group(function() {
            Route::get('supplychain/warehouse/select2', 'WarehouseController@select2')->name('select2');
        });
    });
});