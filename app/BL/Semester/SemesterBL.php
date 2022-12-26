<?php

namespace App\BL\Semester;

use Log;
use App\AO\Semester\SemesterAO;

class SemesterBL
{

    public static function getAllSemesters()
    {
        $response['status'] = 400;
        try {
            $semesters = SemesterAO::getAllSemesters();
            $response['data'] = $semesters;
            $response['status'] = 200;
        } catch (\Throwable $th) {
            $response['msg'] = "No fue posible obtener los semestres del sistema.";
            Log::error('No fue posible obtener los semestres del sistema. | E: ' .
                $th->getMessage() . ' | L: ' . $th->getLine() . ' | F:' . $th->getFile());
        }
        return $response;
    }
}
