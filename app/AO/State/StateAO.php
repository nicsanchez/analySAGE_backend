<?php

namespace App\AO\State;

use DB;

class StateAO
{
    public static function getStateByCodeAndCountryId($code, $countryId)
    {
        $state = DB::table('state')
                ->select('id')
                ->where('consecutive', $code)
                ->where('id_country', $countryId)
                ->first();
        return $state ? $state->id : null;
    }

    public static function storeState($data)
    {
        return DB::table('state')->insertGetId($data);
    }

    public static function updateState($data, $idState)
    {
        return DB::table('state')->where('id', $idState)->update($data);
    }
}
