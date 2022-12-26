<?php

namespace App\AO\Stratum;

use DB;

class StratumAO
{
    public static function getAllStratums()
    {
        return DB::table('stratum')
            ->select('id', 'number')
            ->get();
    }
}
