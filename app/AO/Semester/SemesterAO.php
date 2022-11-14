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
}
