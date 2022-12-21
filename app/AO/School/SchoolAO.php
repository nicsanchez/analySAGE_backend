<?php

namespace App\AO\School;

use DB;

class SchoolAO
{
    public static function getSchoolByCode($code)
    {
        $school = DB::table('school')
                ->select('id')
                ->where('consecutive', $code)
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
