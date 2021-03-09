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

        Route::resource('/unit-class', 'UnitClassController');
        Route::name('unit-class.')->group(function() {
            Route::get('supplychain/unit-class/select2', 'UnitClassController@select2')->name('select2');
        });

        Route::resource('/unit', 'UnitController');
        Route::name('unit.')->group(function() {
            Route::get('supplychain/unit/select2', 'UnitController@select2')->name('select2');
            Route::get('supplychain/unit/select2Mass', 'UnitController@select2Mass')->name('select2.mass');
        });

        Route::resource('/item-category', 'ItemCategoryController');
        Route::name('item-category.')->group(function() {
            Route::get('supplychain/item-category/select2', 'ItemCategoryController@select2')->name('select2');
        });

        Route::resource('/item', 'ItemController');
        Route::name('item.')->group(function() {
            Route::get('supplychain/item/select2', 'ItemController@select2')->name('select2');
        });

        Route::get('/mutation-inbound/detail-tree', 'StockMutationInboundDetailController@tree')->name('mutation-inbound.detail-tree');

        Route::resource('/mutation-inbound', 'StockMutationInboundController');

        Route::resource('/mutation-inbound-detail', 'StockMutationInboundDetailController');        
        Route::name('mutation-inbound-detail.')->group(function() {
            Route::get('supplychain/mutation-inbound-detail/select2', 'StockMutationInboundDetailController@select2Parent')->name('select2');
        });

        Route::resource('/mutation-outbound', 'StockMutationOutboundController');
        Route::resource('/mutation-transfer', 'StockMutationTransferController');

        Route::resource('/stock-monitoring', 'StockMonitoringController');
    });
});