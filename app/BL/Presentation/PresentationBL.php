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

    public static function getDetailsAdmittedOrUnAdmittedPeople($request, $orderBy)
    {
        $response['status'] = 400;
        try {
            if (!$request['semester']) {
                $request['semester'] = SemesterAO::getMaxSemesterId();
            }
            $response['data'] = PresentationAO::getAdmittedOrUnAdmittedPeople($request, $request['type'], $orderBy);
            $response['status'] = 200;
        } catch (\Throwable $th) {
            $response['msg'] = "No fue posible obtener el detalle de estadisticas por estado de admisión.";
            Log::error('No fue posible obtener el detalle de estadisticas por estado de admisión. | E: ' .
                $th->getMessage() . ' | L: ' . $th->getLine() . ' | F:' . $th->getFile());
        }
        return $response;
    }

    public static function getAverageExamComponent($request)
    {
        $response['status'] = 400;
        try {
            if (!$request['semester']) {
                $request['semester'] = SemesterAO::getMaxSemesterId();
            }
            $response['right'] = PresentationAO::getAverageExamComponent($request, 'p.lc_score', 'ff.name');
            $response['bad'] = PresentationAO::getAverageExamComponent($request, 'p.rl_score', 'ff.name');
            $response['status'] = 200;
        } catch (\Throwable $th) {
            $response['msg'] = "No fue posible obtener datos para el grafo de estadisticas por componente del examen.";
            Log::error('No fue posible obtener datos para el grafo de estadisticas por componente del examen. | E: ' .
                $th->getMessage() . ' | L: ' . $th->getLine() . ' | F:' . $th->getFile());
        }
        return $response;
    }

    public static function getDetailsAverageExamComponent($request, $orderBy)
    {
        $response['status'] = 400;
        try {
            if (!$request['semester']) {
                $request['semester'] = SemesterAO::getMaxSemesterId();
            }

            if ($request['type'] == 1) {
                $response['data'] = PresentationAO::getAverageExamComponent($request, 'p.rl_score', $orderBy);
            } else {
                $response['data'] = PresentationAO::getAverageExamComponent($request, 'p.lc_score', $orderBy);
            }

            $response['status'] = 200;
        } catch (\Throwable $th) {
            $response['msg'] = "No fue posible obtener el detalle de estadisticas por componente del examen.";
            Log::error('No fue posible obtener el detalle de estadisticas por componente del examen. | E: ' .
                $th->getMessage() . ' | L: ' . $th->getLine() . ' | F:' . $th->getFile());
        }
        return $response;
    }
}
