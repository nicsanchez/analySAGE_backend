<?php

namespace App\AO\Journey;

use DB;

class JourneyAO
{
    public static function getAllJourneys($idSemester)
    {
        return DB::table('presentation')
            ->select('day_session')
            ->distinct()
            ->where('id_semester', $idSemester)
            ->whereNotNull('day_session')
            ->get();
    }
}
