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
        Route::name('document-type.')->group(function() {
            Route::get('qualityassurance/document-type/select2', 'DocumentTypeController@select2')->name('select2');
        });

        Route::resource('/engineering-level', 'EngineeringLevelController');

        Route::name('engineering-level.')->group(function() {
            Route::get('qualityassurance/engineering-level/select2', 'EngineeringLevelController@select2')->name('select2');
        });

        Route::resource('/task-release-level', 'TaskReleaseLevelController');
    });
});