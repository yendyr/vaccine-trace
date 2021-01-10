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

Route::name('qualityassurance.')->group(function () {
    Route::prefix('qualityassurance')->group(function() {
        Route::resource('/skill', 'SkillController');
        Route::resource('/document-type', 'DocumentTypeController');
        Route::resource('/engineering-level', 'EngineeringLevelController');
    });
});