<?php

namespace App\AO\School;

use DB;

class SchoolAO
{
    public static function getSchoolByCodeAndMunicipalityId($code, $municipalityId)
    {
        $school = DB::table('school')
                ->select('id')
                ->where('consecutive', $code)
                ->where('id_municipality', $municipalityId)
                ->first();
        return $school ? $school->id : null;
    }

    public static function storeSchool($data)
    {
        DB::table('school')->insert($data);
    }

    public static function updateSchool($data, $idSchool)
    {
        DB::table('school')->where('id', $idSchool)->update($data);
    }
}
