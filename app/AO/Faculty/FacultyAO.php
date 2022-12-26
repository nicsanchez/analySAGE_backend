<?php

namespace App\AO\Faculty;

use DB;

class FacultyAO
{
    public static function getFacultyByCode($code)
    {
        $faculty = DB::table('faculty')
                ->select('id')
                ->where('consecutive', $code)
                ->first();
        return $faculty ? $faculty->id : null;
    }

    public static function storeFaculty($data)
    {
        return DB::table('faculty')->insertGetId($data);
    }

    public static function updateFaculty($data, $idFaculty)
    {
        DB::table('faculty')->where('id', $idFaculty)->update($data);
    }

    public static function getAllFaculties()
    {
        return DB::table('faculty')
            ->select('id', 'name')
            ->get();
    }
}
