<?php

use Illuminate\Support\Facades\Route;

/*
Capa de Rutas: En esta capa se definen las rutas API las cuales pueden ser consumidas.
Author: David Nicolás Sánchez Sendoya, Augusto Enrique Salazar

 */

Route::post('login', 'App\Http\Controllers\AuthenticateController@authenticate');

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::post('logout', 'App\Http\Controllers\AuthenticateController@logout');

    Route::group(['middleware' => ['permissions.verify']], function () {
        Route::group(['prefix' => 'users'], function () {
            Route::post('getUsers', 'App\Http\Controllers\Users\UsersController@getUsers');
            Route::post('createUser', 'App\Http\Controllers\Users\UsersController@createUser');
            Route::post('deleteUser', 'App\Http\Controllers\Users\UsersController@deleteUser');
            Route::post('updateUser', 'App\Http\Controllers\Users\UsersController@updateUser');
        });
        Route::group(['prefix' => 'logs'], function () {
            Route::post('getLogs', 'App\Http\Controllers\Logs\LogsController@getLogs');
        });
        Route::group(['prefix' => 'roles'], function () {
            Route::post('getAllRoles', 'App\Http\Controllers\Roles\RolesController@getAllRoles');
        });
        Route::group(['prefix' => 'inscribed'], function () {
            Route::post(
                'storeInscribedBySemester',
                'App\Http\Controllers\Inscribed\InscribedController@storeInscribedBySemester'
            );
        });
        Route::group(['prefix' => 'questions'], function () {
            Route::post('storeQuestions', 'App\Http\Controllers\Questions\QuestionsController@storeQuestions');
        });
        Route::group(['prefix' => 'answers'], function () {
            Route::post('storeAnswers', 'App\Http\Controllers\Answers\AnswersController@storeAnswers');
        });
        Route::group(['prefix' => 'municipality'], function () {
            Route::post(
                'storeMunicipalities',
                'App\Http\Controllers\Municipality\MunicipalityController@storeMunicipalities'
            );
        });
        Route::group(['prefix' => 'school'], function () {
            Route::post(
                'storeSchools',
                'App\Http\Controllers\School\SchoolController@storeSchools'
            );
        });
        Route::group(['prefix' => 'program'], function () {
            Route::post(
                'storePrograms',
                'App\Http\Controllers\Program\ProgramController@storePrograms'
            );
        });
    });

    Route::group(['prefix' => 'users'], function () {
        Route::post('getUser', 'App\Http\Controllers\Users\UsersController@getUser');
        Route::post('updatePersonalData', 'App\Http\Controllers\Users\UsersController@updatePersonalData');
    });

    Route::group(['prefix' => 'roles'], function () {
        Route::post('getPermissions', 'App\Http\Controllers\Roles\RolesController@getPermissions');
    });

    Route::group(['prefix' => 'statistics'], function () {
        Route::post(
            'getRightAndBadAnswersQuantity',
            'App\Http\Controllers\Answers\AnswersController@getRightAndBadAnswersQuantity'
        );
    });
});
