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

        Route::post(
            'getDetailsAnswerByVersion',
            'App\Http\Controllers\Answers\AnswersController@getDetailsAnswerByVersion'
        );

        Route::post(
            'getDetailsAnswerByState',
            'App\Http\Controllers\Answers\AnswersController@getDetailsAnswerByState'
        );

        Route::post(
            'getDetailsAnswerByStratum',
            'App\Http\Controllers\Answers\AnswersController@getDetailsAnswerByStratum'
        );

        Route::post(
            'getDetailsAnswerByFacultyFirstOption',
            'App\Http\Controllers\Answers\AnswersController@getDetailsAnswerByFacultyFirstOption'
        );

        Route::post(
            'getDetailsAnswerByRegistrationType',
            'App\Http\Controllers\Answers\AnswersController@getDetailsAnswerByRegistrationType'
        );

        Route::post(
            'getAdmittedOrUnAdmittedPeople',
            'App\Http\Controllers\Presentation\PresentationController@getAdmittedOrUnAdmittedPeople'
        );

        Route::post(
            'getDetailsAdmittedOrUnAdmittedPeopleByVersion',
            'App\Http\Controllers\Presentation\PresentationController@getDetailsAdmittedOrUnAdmittedPeopleByVersion'
        );

        Route::post(
            'getDetailsAdmittedOrUnAdmittedPeopleByState',
            'App\Http\Controllers\Presentation\PresentationController@getDetailsAdmittedOrUnAdmittedPeopleByState'
        );

        Route::post(
            'getDetailsAdmittedOrUnAdmittedPeopleByStratum',
            'App\Http\Controllers\Presentation\PresentationController@getDetailsAdmittedOrUnAdmittedPeopleByStratum'
        );

        Route::post(
            'getDetailsAdmittedOrUnAdmittedPeopleByProgram',
            'App\Http\Controllers\Presentation\PresentationController@getDetailsAdmittedOrUnAdmittedPeopleByProgram'
        );

        Route::post(
            'getDetailsAdmittedOrUnAdmittedPeopleByRegistrationType',
            'App\Http\Controllers\Presentation\PresentationController@getDetailsAdmittedOrUnAdmittedPeopleByRegistrationType'
        );

        Route::post(
            'getAverageExamComponent',
            'App\Http\Controllers\Presentation\PresentationController@getAverageExamComponent'
        );

        Route::post(
            'getDetailsAverageExamComponentByVersion',
            'App\Http\Controllers\Presentation\PresentationController@getDetailsAverageExamComponentByVersion'
        );

        Route::post(
            'getDetailsAverageExamComponentByState',
            'App\Http\Controllers\Presentation\PresentationController@getDetailsAverageExamComponentByState'
        );

        Route::post(
            'getDetailsAverageExamComponentByStratum',
            'App\Http\Controllers\Presentation\PresentationController@getDetailsAverageExamComponentByStratum'
        );

        Route::post(
            'getDetailsAverageExamComponentByProgram',
            'App\Http\Controllers\Presentation\PresentationController@getDetailsAverageExamComponentByProgram'
        );

        Route::post(
            'getDetailsAverageExamComponentByRegistrationType',
            'App\Http\Controllers\Presentation\PresentationController@getDetailsAverageExamComponentByRegistrationType'
        );
    });

    Route::group(['prefix' => 'semester'], function () {
        Route::post(
            'getAllSemesters',
            'App\Http\Controllers\Semester\SemesterController@getAllSemesters'
        );
    });

    Route::group(['prefix' => 'journey'], function () {
        Route::post(
            'getAllJourneys',
            'App\Http\Controllers\Journey\JourneyController@getAllJourneys'
        );
    });

    Route::group(['prefix' => 'stratum'], function () {
        Route::post(
            'getAllStratums',
            'App\Http\Controllers\Stratum\StratumController@getAllStratums'
        );
    });

    Route::group(['prefix' => 'gender'], function () {
        Route::post(
            'getAllGenders',
            'App\Http\Controllers\Gender\GenderController@getAllGenders'
        );
    });

    Route::group(['prefix' => 'program'], function () {
        Route::post(
            'getProgramsByFaculty',
            'App\Http\Controllers\Program\ProgramController@getProgramsByFaculty'
        );
    });

    Route::group(['prefix' => 'continent'], function () {
        Route::post(
            'getAllContinents',
            'App\Http\Controllers\Continent\ContinentController@getAllContinents'
        );
    });

    Route::group(['prefix' => 'country'], function () {
        Route::post(
            'getAllCountriesByContinent',
            'App\Http\Controllers\Country\CountryController@getAllCountriesByContinent'
        );
    });

    Route::group(['prefix' => 'state'], function () {
        Route::post(
            'getAllStatesByCountry',
            'App\Http\Controllers\State\StateController@getAllStatesByCountry'
        );
    });

    Route::group(['prefix' => 'municipality'], function () {
        Route::post(
            'getAllMunicipalitiesByState',
            'App\Http\Controllers\Municipality\MunicipalityController@getAllMunicipalitiesByState'
        );
    });

    Route::group(['prefix' => 'school'], function () {
        Route::post(
            'getAllNaturalness',
            'App\Http\Controllers\School\SchoolController@getAllNaturalness'
        );

        Route::post(
            'getAllSchoolsByNaturalnessAndLocation',
            'App\Http\Controllers\School\SchoolController@getAllSchoolsByNaturalnessAndLocation'
        );
    });

    Route::group(['prefix' => 'faculty'], function () {
        Route::post(
            'getAllFaculties',
            'App\Http\Controllers\Faculty\FacultyController@getAllFaculties'
        );
    });
});
