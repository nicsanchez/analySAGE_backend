<?php

namespace App\BL\Stratum;

use Log;
use App\AO\Stratum\StratumAO;

class StratumBL
{

    public static function getAllStratums()
    {
        $response['status'] = 400;
        try {
            $stratums = StratumAO::getAllStratums();
            $response['data'] = $stratums;
            $response['status'] = 200;
        } catch (\Throwable $th) {
            $response['msg'] = "No fue posible obtener los estratos del sistema.";
            Log::error('No fue posible obtener los estratos del sistema. | E: ' .
                $th->getMessage() . ' | L: ' . $th->getLine() . ' | F:' . $th->getFile());
        }
        return $response;
    }
}
