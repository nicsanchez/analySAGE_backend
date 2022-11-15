<?php

namespace App\AO\AcceptanceType;

use DB;

class AcceptanceTypeAO
{
    public static function findAcceptanceTypeId($acceptanceType)
    {
        return DB::table('acceptance_type')
            ->select('id')
            ->where('name', $acceptanceType)
            ->get();
    }
}
