<?php

namespace App\AO\Semester;

use DB;

class SemesterAO
{
    public static function findSemesterId($semester)
    {
        return DB::table('semester')
            ->select('id')
            ->where('name', $semester)
            ->first();
    }

    public static function insertNewSemester($data)
    {
        return DB::table('semester')->insertGetId($data);
    }

    public static function getMaxSemesterId()
    {
        $semester = DB::table('semester')->select('id')->whereRaw('name = (select max(`name`) from semester)')->first();
        return ($semester ? $semester->id : null);
    }
}
