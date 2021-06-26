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

        Route::get('/chart-of-account/detail-tree', 'ChartOfAccountController@tree')->name('chart-of-account.detail-tree');

        Route::resource('/chart-of-account', 'ChartOfAccountController');
        Route::name('chart-of-account.')->group(function() {
            Route::get('accounting/chart-of-account/select2/parent', 'ChartOfAccountController@select2Parent')->name('select2.parent');
            Route::get('accounting/chart-of-account/select2/child', 'ChartOfAccountController@select2Child')->name('select2.child');
        });

        Route::name('item-category.')->group(function() {
            Route::get('item-category', [Modules\SupplyChain\Http\Controllers\ItemCategoryController::class, 'index_accounting'])->name('index_accounting');
            Route::patch('item-category/{item_category}', [Modules\SupplyChain\Http\Controllers\ItemCategoryController::class, 'update_accounting'])->name('update_accounting');
        });

        Route::name('item.')->group(function() {
            Route::get('item', [Modules\SupplyChain\Http\Controllers\ItemController::class, 'index_accounting'])->name('index_accounting');
            Route::patch('item/{item}', [Modules\SupplyChain\Http\Controllers\ItemController::class, 'update_accounting'])->name('update_accounting');
        });

        Route::resource('/journal', 'JournalController');
        Route::resource('/journal-detail', 'JournalDetailController');
        Route::post('/journal/{journal}/approve', 'JournalController@approve');

        Route::resource('/general-ledger', 'GeneralLedgerController');
        Route::resource('/trial-balance', 'TrialBalanceController');
        Route::resource('/profit-loss', 'ProfitLossController');
        Route::resource('/balance-sheet', 'BalanceSheetController');
    });
});
