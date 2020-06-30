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

Route::name('gate.')->group(function () {
    Route::prefix('gate')->group(function() {
        Route::resource('/user', 'UserController');
        Route::resource('/company', 'CompanyController');
        Route::resource('/role', 'RoleController');
        Route::resource('/role-menu', 'RoleMenuController');
        Route::get('/', 'GateController@index');
        //Route::view('/test', 'gate::pages.test.index')->name('test.index');
    });
});
