<?php

namespace App\BL\Continent;

use Log;
use App\AO\Continent\ContinentAO;

class ContinentBL
{

    public static function getAllContinents()
    {
        $response['status'] = 400;
        try {
            $response['data'] = ContinentAO::getAllContinents();
            $response['status'] = 200;
        } catch (\Throwable $th) {
            $response['msg'] = "No fue posible obtener las continentes del sistema.";
            Log::error('No fue posible obtener los continentes del semestre. | E: ' .
                $th->getMessage() . ' | L: ' . $th->getLine() . ' | F:' . $th->getFile());
        }
        return $response;
    }
}
