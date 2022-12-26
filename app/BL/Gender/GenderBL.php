<?php

namespace App\BL\Gender;

use Log;
use App\AO\Gender\GenderAO;

class GenderBL
{

    public static function getAllGenders()
    {
        $response['status'] = 400;
        try {
            $genders = GenderAO::getAllGenders();
            $response['data'] = $genders;
            $response['status'] = 200;
        } catch (\Throwable $th) {
            $response['msg'] = "No fue posible obtener los géneros del sistema.";
            Log::error('No fue posible obtener los géneros del sistema. | E: ' .
                $th->getMessage() . ' | L: ' . $th->getLine() . ' | F:' . $th->getFile());
        }
        return $response;
    }
}
