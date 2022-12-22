<?php

namespace App\AO\Presentation;

use DB;

class PresentationAO
{

    public static function getPresentationBySemesterAndPersonalInfo($semester, $personalInfoId)
    {
        return DB::table('presentation')->where('id_personal_information', $personalInfoId)
            ->where('id_semester', $semester)
            ->get();
    }

    public static function updatePresentation($dataPresentation, $id)
    {
        DB::table('presentation')
            ->where('id', $id)
            ->update($dataPresentation);
    }

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

    public static function semesterHaveMoreThanOnePresentations($semester)
    {
        $presentations = DB::table('presentation')
            ->select('id')
            ->where('id_semester', $semester)
            ->get();

        return ($presentations->count() > 0);
    }
}
