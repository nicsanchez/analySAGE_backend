<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Presentation\PresentationController;
use App\Http\Controllers\Answers\AnswersController;
use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\Users\UsersController;
use App\Http\Controllers\Logs\LogsController;
use App\Http\Controllers\Roles\RolesController;
use App\Http\Controllers\Inscribed\InscribedController;
use App\Http\Controllers\Questions\QuestionsController;
use App\Http\Controllers\Municipality\MunicipalityController;
use App\Http\Controllers\School\SchoolController;
use App\Http\Controllers\Program\ProgramController;
use App\Http\Controllers\Semester\SemesterController;
use App\Http\Controllers\Journey\JourneyController;
use App\Http\Controllers\Stratum\StratumController;
use App\Http\Controllers\Gender\GenderController;
use App\Http\Controllers\Continent\ContinentController;
use App\Http\Controllers\Country\CountryController;
use App\Http\Controllers\State\StateController;
use App\Http\Controllers\Faculty\FacultyController;

/*
Capa de Rutas: En esta capa se definen las rutas API las cuales pueden ser consumidas.
Author: David Nicolás Sánchez Sendoya, Augusto Enrique Salazar

 */

Route::post('login', AuthenticateController::class . '@authenticate');

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::post('logout', AuthenticateController::class . '@logout');

    Route::group(['middleware' => ['permissions.verify']], function () {
        Route::group(['prefix' => 'users'], function () {
            $usersRoutes = ['getUsers', 'createUser', 'deleteUser', 'updateUser'];

            foreach ($usersRoutes as $userRoute) {
                Route::post($userRoute, UsersController::class .'@'. $userRoute);
            }

        });

        Route::group(['prefix' => 'logs'], function () {
            Route::post('getLogs', LogsController::class . '@getLogs');
        });

        Route::group(['prefix' => 'roles'], function () {
            Route::post('getAllRoles', RolesController::class . '@getAllRoles');
        });

        Route::group(['prefix' => 'inscribed'], function () {
            Route::post(
                'storeInscribedBySemester',
                InscribedController::class . '@storeInscribedBySemester'
            );
        });

        Route::group(['prefix' => 'questions'], function () {
            Route::post('storeQuestions', QuestionsController::class . '@storeQuestions');
        });

        Route::group(['prefix' => 'answers'], function () {
            Route::post('storeAnswers', AnswersController::class . '@storeAnswers');
        });

        Route::group(['prefix' => 'municipality'], function () {
            Route::post(
                'storeMunicipalities',
                MunicipalityController::class . '@storeMunicipalities'
            );
        });

        Route::group(['prefix' => 'school'], function () {
            Route::post(
                'storeSchools',
                SchoolController::class . '@storeSchools'
            );
        });

        Route::group(['prefix' => 'program'], function () {
            Route::post(
                'storePrograms',
                ProgramController::class . '@storePrograms'
            );
        });
    });

    Route::group(['prefix' => 'users'], function () {
        Route::post('getUser', UsersController::class . '@getUser');
        Route::post('updatePersonalData', UsersController::class . '@updatePersonalData');
    });

    Route::group(['prefix' => 'roles'], function () {
        Route::post('getPermissions', RolesController::class . '@getPermissions');
    });

    Route::group(['prefix' => 'statistics'], function () {

        $answersRoutes = [
            'getRightAndBadAnswersQuantity',
            'getDetailsAnswerByVersion',
            'getDetailsAnswerByState',
            'getDetailsAnswerByStratum',
            'getDetailsAnswerByFacultyFirstOption',
            'getDetailsAnswerByRegistrationType'
        ];

        $presentationRoutes = [
            'getAdmittedOrUnAdmittedPeople',
            'getDetailsAdmittedOrUnAdmittedPeopleByVersion',
            'getDetailsAdmittedOrUnAdmittedPeopleByState',
            'getDetailsAdmittedOrUnAdmittedPeopleByStratum',
            'getDetailsAdmittedOrUnAdmittedPeopleByProgram',
            'getDetailsAdmittedOrUnAdmittedPeopleByRegistrationType',
            'getAverageExamComponent',
            'getDetailsAverageExamComponentByVersion',
            'getDetailsAverageExamComponentByState',
            'getDetailsAverageExamComponentByStratum',
            'getDetailsAverageExamComponentByProgram',
            'getDetailsAverageExamComponentByRegistrationType'
        ];

        foreach ($answersRoutes as $answersRoute) {
            Route::post($answersRoute, AnswersController::class .'@'. $answersRoute);
        }

        foreach ($presentationRoutes as $presentationRoute) {
            Route::post($presentationRoute, PresentationController::class .'@'. $presentationRoute);
        }
    });

    Route::group(['prefix' => 'semester'], function () {
        Route::post(
            'getAllSemesters',
            SemesterController::class . '@getAllSemesters'
        );
    });

    Route::group(['prefix' => 'journey'], function () {
        Route::post(
            'getAllJourneys',
            JourneyController::class . '@getAllJourneys'
        );
    });

    Route::group(['prefix' => 'stratum'], function () {
        Route::post(
            'getAllStratums',
            StratumController::class . '@getAllStratums'
        );
    });

    Route::group(['prefix' => 'gender'], function () {
        Route::post(
            'getAllGenders',
            GenderController::class . '@getAllGenders'
        );
    });

    Route::group(['prefix' => 'program'], function () {
        Route::post(
            'getProgramsByFaculty',
            ProgramController::class . '@getProgramsByFaculty'
        );
    });

    Route::group(['prefix' => 'continent'], function () {
        Route::post(
            'getAllContinents',
            ContinentController::class . '@getAllContinents'
        );
    });

    Route::group(['prefix' => 'country'], function () {
        Route::post(
            'getAllCountriesByContinent',
            CountryController::class . '@getAllCountriesByContinent'
        );
    });

    Route::group(['prefix' => 'state'], function () {
        Route::post(
            'getAllStatesByCountry',
            StateController::class . '@getAllStatesByCountry'
        );
    });

    Route::group(['prefix' => 'municipality'], function () {
        Route::post(
            'getAllMunicipalitiesByState',
            MunicipalityController::class . '@getAllMunicipalitiesByState'
        );
    });

    Route::group(['prefix' => 'school'], function () {
        Route::post(
            'getAllNaturalness',
            SchoolController::class . '@getAllNaturalness'
        );

        Route::post(
            'getAllSchoolsByNaturalnessAndLocation',
            SchoolController::class . '@getAllSchoolsByNaturalnessAndLocation'
        );
    });

    Route::group(['prefix' => 'faculty'], function () {
        Route::post(
            'getAllFaculties',
            FacultyController::class . '@getAllFaculties'
        );
    });
});
