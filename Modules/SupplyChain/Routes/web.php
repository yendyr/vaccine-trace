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
        Route::post('/mutation-inbound/{mutation_inbound}/approve', 'StockMutationInboundController@approve');
        Route::resource('/mutation-inbound-detail', 'StockMutationInboundDetailController');        
        Route::name('mutation-inbound-detail.')->group(function() {
            Route::get('supplychain/mutation-inbound-detail/select2', 'StockMutationInboundDetailController@select2Parent')->name('select2');
        });

        Route::get('/mutation-outbound/detail-tree', 'StockMutationOutboundDetailController@tree')->name('mutation-outbound.detail-tree');
        Route::resource('/mutation-outbound', 'StockMutationOutboundController');
        Route::post('/mutation-outbound/{mutation_outbound}/approve', 'StockMutationOutboundController@approve');
        Route::resource('/mutation-outbound-detail', 'StockMutationOutboundDetailController');        
        Route::name('mutation-outbound-detail.')->group(function() {
            Route::get('supplychain/mutation-outbound-detail/select2', 'StockMutationOutboundDetailController@select2Parent')->name('select2');
        });

        Route::get('/mutation-transfer/detail-tree', 'StockMutationTransferDetailController@tree')->name('mutation-transfer.detail-tree');
        Route::resource('/mutation-transfer', 'StockMutationTransferController');
        Route::post('/mutation-transfer/{mutation_transfer}/approve', 'StockMutationTransferController@approve');
        Route::resource('/mutation-transfer-detail', 'StockMutationTransferDetailController');        
        Route::name('mutation-transfer-detail.')->group(function() {
            Route::get('supplychain/mutation-transfer-detail/select2', 'StockMutationTransferDetailController@select2Parent')->name('select2');
        });

        Route::resource('/stock-monitoring', 'StockMonitoringController');
    });
});