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

Route::name('procurement.')->group(function() {
    Route::prefix('procurement')->group(function() {

        Route::get('/purchase-requisition/outstanding', 'PurchaseRequisitionDetailController@outstanding_purchase_request_details')->name('purchase-requisition.outstanding');
        Route::get('/purchase-requisition/detail-tree', 'PurchaseRequisitionDetailController@tree')->name('purchase-requisition.detail-tree');
        
        Route::resource('/purchase-requisition', 'PurchaseRequisitionController');
        Route::post('/purchase-requisition/{purchase_requisition}/approve', 'PurchaseRequisitionController@approve');
        
        Route::resource('/purchase-requisition-detail', 'PurchaseRequisitionDetailController');        
        Route::name('purchase-requisition-detail.')->group(function() {
            Route::get('procurement/purchase-requisition-detail/select2', 'PurchaseRequisitionDetailController@select2Parent')->name('select2');
        });

        Route::get('/purchase-order/detail-tree', 'PurchaseOrderDetailController@tree')->name('purchase-order.detail-tree');

        Route::resource('/purchase-order', 'PurchaseOrderController');
        Route::post('/purchase-order/{purchase_order}/approve', 'PurchaseOrderController@approve');

        Route::resource('/purchase-order-detail', 'PurchaseOrderDetailController');        
        Route::name('purchase-order-detail.')->group(function() {
            Route::get('procurement/purchase-order-detail/select2', 'PurchaseOrderDetailController@select2Parent')->name('select2');
        });

    });
});