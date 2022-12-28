<?php

namespace App\BL\Presentation;

use Log;
use App\BL\Logs\LogsBL;
use App\AO\Presentation\PresentationAO;
use App\AO\Semester\SemesterAO;

class PresentationBL
{

    public static function getAdmittedOrUnAdmittedPeople($request)
    {
        $response['status'] = 400;
        try {
            if (!$request['semester']) {
                $request['semester'] = SemesterAO::getMaxSemesterId();
            }
            $response['right'] = PresentationAO::getAdmittedOrUnAdmittedPeople($request, 1, 'af.name');
            $response['bad'] = PresentationAO::getAdmittedOrUnAdmittedPeople($request, 0, 'ff.name');
            $response['status'] = 200;
        } catch (\Throwable $th) {
            $response['msg'] = "No fue posible obtener datos para el grafo de estadisticas por estado de admisión.";
            Log::error('No fue posible obtener datos para el grafo de estadisticas por estado de admisión. | E: ' .
                $th->getMessage() . ' | L: ' . $th->getLine() . ' | F:' . $th->getFile());
        }
        return $response;
    }
}
