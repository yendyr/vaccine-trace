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
    Route::prefix('gate')->group(function () {
        Route::name('user.')->group(function () {
            Route::get('/user/select2/role', 'UserController@select2Role')->name('select2.role');
            Route::get('/user/select2/company', 'UserController@select2Company')->name('select2.company');
            Route::post('/user/change-password', 'UserController@changePassword')->name('change-password');
            Route::post('/user/upload-image', 'UserController@uploadImage')->name('upload-image');
        });
        Route::resource('/user', 'UserController');

        Route::resource('/role', 'RoleController');

        Route::name('menu.')->group(function () {
            Route::get('/menu/select2/all', 'MenuController@select2Menu')->name('select2.all');
        });
        Route::resource('/menu', 'MenuController');

        Route::name('role-menu.')->group(function () {
            Route::get('/role-menu/select2/role', 'RoleMenuController@select2Role')->name('select2.role');
            Route::get('/role-menu/datatable/{role}', 'RoleMenuController@fetch')->name('datatable');
        });

        Route::resource('/role-menu', 'RoleMenuController');

        // Route::get('/', 'GateController@index');
        // Route::view('/test', 'gate::pages.test.index')->name('test.index');
    });
});
