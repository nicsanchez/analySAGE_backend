<?php

namespace App\BL\State;

use Log;
use App\AO\State\StateAO;

class StateBL
{

    public static function getAllStatesByCountry($idCountry)
    {
        $response['status'] = 400;
        try {
            $response['data'] = StateAO::getAllStatesByCountry($idCountry);
            $response['status'] = 200;
        } catch (\Throwable $th) {
            $response['msg'] = "No fue posible obtener los departamentos del pais.";
            Log::error('No fue posible obtener los departamentos del pais. | E: ' .
                $th->getMessage() . ' | L: ' . $th->getLine() . ' | F:' . $th->getFile());
        }
        return $response;
    }
}
