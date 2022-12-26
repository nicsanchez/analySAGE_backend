<?php

namespace App\BL\Faculty;

use Log;
use App\AO\Faculty\FacultyAO;

class FacultyBL
{

    public static function getAllFaculties()
    {
        $response['status'] = 400;
        try {
            $response['data'] = FacultyAO::getAllFaculties();
            $response['status'] = 200;
        } catch (\Throwable $th) {
            $response['msg'] = "No fue posible obtener las facultades del sistema.";
            Log::error('No fue posible obtener las facultadess del sistema. | E: ' .
                $th->getMessage() . ' | L: ' . $th->getLine() . ' | F:' . $th->getFile());
        }
        return $response;
    }
}
