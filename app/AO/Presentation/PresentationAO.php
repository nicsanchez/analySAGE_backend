<?php

namespace App\AO\Presentation;

use DB;

class PresentationAO
{
    public static function storePresentation($data)
    {
        DB::table('presentation')->insert($data);
    }

    public static function findByCredentialSemester($semester, $credential)
    {
        return DB::table('presentation')
            ->select('id', 'day_session')
            ->where('id_semester', $semester)
            ->where('credential', $credential)
            ->first();
    }
}
