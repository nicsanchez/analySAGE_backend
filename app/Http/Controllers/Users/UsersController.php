<?php

/*
    Capa Controlador: Capa de validación de datos mediante el uso de Requests para el módulo de usuarios
    Author: David Nicolás Sánchez Sendoya, Augusto Enrique Salazar
*/

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BL\Users\UsersBL;
use App\Http\Requests\Users\CreateUser;
use App\Http\Requests\Users\EditUser;
use App\Http\Requests\Users\EditLoggedUser;

class UsersController extends Controller
{
    public function getUsers(Request $request){
        return UsersBL::getUsers($request->input());
    }

    public function getUser(Request $request){
        return UsersBL::getUser();
    }

    public function createUser(CreateUser $request){
        return UsersBL::createUser($request->input('data'));
    }

    public function updateUser(EditUser $request){
        return UsersBL::updateUser($request->input('data'));
    }

    public function updatePersonalData(EditLoggedUser $request){
        return UsersBL::updatePersonalData($request->input('data'));
    }

    public function deleteUser(Request $request){
        return UsersBL::deleteUser($request->input());
    }
}
