<?php

namespace App\BL\Journey;

use Log;
use App\AO\Journey\JourneyAO;

class JourneyBL
{

    public static function getAllJourneys($idSemester)
    {
        $response['status'] = 400;
        try {
            $journeys = JourneyAO::getAllJourneys($idSemester);
            $response['data'] = $journeys;
            $response['status'] = 200;
        } catch (\Throwable $th) {
            $response['msg'] = "No fue posible obtener las jornadas del semestre.";
            Log::error('No fue posible obtener las jornadas del semestre. | E: ' .
                $th->getMessage() . ' | L: ' . $th->getLine() . ' | F:' . $th->getFile());
        }
        return $response;
    }
}
