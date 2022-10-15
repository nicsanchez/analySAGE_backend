<?php

/*
    Capa Middleware relacionado con el inicio de sesión
    Author: David Nicolás Sánchez Sendoya, Augusto Enrique Salazar
*/

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;

class JwtMiddleware extends BaseMiddleware
{

    public function handle($request, Closure $next)
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 900, 'data' => 'Token inválido']);
        } catch (TokenExpiredException $e){
            return response()->json(['status' => 901, 'data' => 'Token expirado']);
        } catch (JWTException $e) {
           return response()->json(['status' => 902, 'data' => 'Falta Token en la peticion']);
        }
        return $next($request);
    }
}

