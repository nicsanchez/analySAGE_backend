<?php

/*
Capa controlador relacionado con el inicio de sessión
Author: David Nicolás Sánchez Sendoya, Augusto Enrique Salazar
 */

namespace App\Http\Controllers;

use App\AO\Authenticate\AuthenticateAO;
use Illuminate\Http\Request;
use JWTAuth;
use Log;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthenticateController extends Controller
{
    /* Método usado para realizar la autenticación de un usuario */
    public function authenticate(Request $request)
    {
        $user = AuthenticateAO::getUserByUsername($request->username);
        if (sizeof($user) == 1) {
            $credentials = ['email' => $user[0]->email, 'password' => $request->password];
            try {
                if (!$token = JWTAuth::attempt($credentials)) {
                    return response()->json(['error' => 'Credenciales Invalidas'], 400);
                }
            } catch (JWTException $e) {
                return response()->json(['error' => 'No fue posible crearse  el token'], 500);
            }
        } else {
            return response()->json(['error' => 'Usuario no existe'], 404);
        }
        return response()->json(compact('token'));
    }

    /* Método usado para realizar la destrucción de token y cerrar sesión */
    public function logout()
    {
        $response['status'] = 400;
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            $response['status'] = 200;
        } catch (\Throwable $th) {
            Log::error('No fue posible cerrar sesión y destruir token M:' . $th->getMessage() . ' | L:' . $th->getLine() . ' F:' . $th->getFile());
        }
        return $response;

    }
}
