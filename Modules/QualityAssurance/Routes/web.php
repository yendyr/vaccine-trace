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
        Route::name('skill.')->group(function() {
            Route::get('qualityassurance/skill/select2', 'SkillController@select2')->name('select2');
        });

        Route::resource('/document-type', 'DocumentTypeController');
        Route::name('document-type.')->group(function() {
            Route::get('qualityassurance/document-type/select2', 'DocumentTypeController@select2')->name('select2');
        });

        Route::resource('/engineering-level', 'EngineeringLevelController');
        Route::name('engineering-level.')->group(function() {
            Route::get('qualityassurance/engineering-level/select2', 'EngineeringLevelController@select2')->name('select2');
        });

        Route::resource('/task-release-level', 'TaskReleaseLevelController');
        Route::name('task-release-level.')->group(function() {
            Route::get('qualityassurance/task-release-level/select2', 'TaskReleaseLevelController@select2')->name('select2');
        });
    });
});