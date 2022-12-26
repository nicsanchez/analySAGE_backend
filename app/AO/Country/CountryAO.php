<?php

namespace App\AO\Country;

use DB;

class CountryAO
{
    public static function getCountryByCodeAndContinentId($code, $continentId)
    {
        $country = DB::table('country')
                ->select('id')
                ->where('consecutive', $code)
                ->where('id_continent', $continentId)
                ->first();
        return $country ? $country->id : null;
    }

    public static function storeCountry($data)
    {
        return DB::table('country')->insertGetId($data);
    }

    public static function updateCountry($data, $idCountry)
    {
        DB::table('country')->where('id', $idCountry)->update($data);
    }

    public static function getAllCountriesByContinent($idContinent)
    {
        return DB::table('country')
            ->select('id', 'name')
            ->where('id_continent', $idContinent)
            ->get();
    }
}
