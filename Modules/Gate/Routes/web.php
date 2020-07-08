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
        Route::get('/user/select2/role', 'UserController@select2Role')->name('user.select2.role');
        Route::get('/user/select2/company', 'UserController@select2Company')->name('user.select2.company');
        Route::resource('/user', 'UserController');

        Route::resource('/company', 'CompanyController');

        Route::resource('/role', 'RoleController');

        Route::get('/role-menu/select2/role', 'RoleMenuController@select2Role')->name('role-menu.select2.role');
        Route::resource('/role-menu', 'RoleMenuController');

        Route::get('/role-menu/datatable/{role}', 'RoleMenuController@fetch')->name('role-menu.datatable');

        Route::get('/', 'GateController@index');

        Route::view('/test', 'gate::pages.test.index')->name('test.index');
    });
});
