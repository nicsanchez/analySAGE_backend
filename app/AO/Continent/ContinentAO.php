<?php

namespace App\AO\Continent;

use DB;

class ContinentAO
{
    public static function getContinentByCode($code)
    {
        $continent = DB::table('continent')
            ->select('id')
            ->where('consecutive', $code)
            ->first();
        return $continent ? $continent->id : null;
    }

    public static function storeContinent($data)
    {
        return DB::table('continent')->insertGetId($data);
    }

    public static function updateContinent($data, $idContinent)
    {
        DB::table('continent')->where('id', $idContinent)->update($data);
    }

    public static function getAllContinents()
    {
        return DB::table('continent')
            ->select('id', 'name')
            ->get();
    }
}
