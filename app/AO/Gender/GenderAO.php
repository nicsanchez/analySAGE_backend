<?php

namespace App\AO\Gender;

use DB;

class GenderAO
{
    public static function findGenderId($gender)
    {
        return DB::table('gender')
            ->select('id')
            ->where('name', $gender)
            ->get();
    }
}
