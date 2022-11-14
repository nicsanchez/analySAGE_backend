<?php

namespace App\AO\RegistrationType;

use DB;

class RegistrationTypeAO
{
    public static function findRegistrationTypeId($registrationType){
        return DB::table('registration_type')
            ->select('id')
            ->where('name', $registrationType)
            ->get();
    }
}
