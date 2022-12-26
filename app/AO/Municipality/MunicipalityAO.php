<?php

namespace App\AO\Municipality;

use DB;

class MunicipalityAO
{
    public static function findMunicipalityId($continent, $country, $state, $municipality)
    {

        $municipality = DB::table('continent as CON')
            ->select('M.id')
            ->join('country as COU', function ($join) use ($country) {
                $join->on('CON.id', '=', 'COU.id_continent')
                    ->where('COU.consecutive', $country);
            })
            ->join('state as S', function ($join) use ($state) {
                $join->on('COU.id', '=', 'S.id_country')
                    ->where('S.consecutive', $state);
            })
            ->join('municipality as M', function ($join) use ($municipality) {
                $join->on('S.id', '=', 'M.id_state')
                    ->where('M.consecutive', $municipality);
            })
            ->where('CON.consecutive', $continent)
            ->first();
        return $municipality ? $municipality->id : null;
    }

    public static function getMunicipalityByCodeAndStateId($code, $stateId)
    {
        $municipality = DB::table('municipality')
            ->select('id')
            ->where('consecutive', $code)
            ->where('id_state', $stateId)
            ->first();
        return $municipality ? $municipality->id : null;
    }

    public static function storeMunicipality($data)
    {
        DB::table('municipality')->insert($data);
    }

    public static function updateMunicipality($data, $idMunicipality)
    {
        DB::table('municipality')->where('id', $idMunicipality)->update($data);
    }

    public static function getMunicipalityIdToColombiansMunicipality($state, $municipality)
    {
        $municipality = DB::table('continent as CON')
            ->select('M.id')
            ->join('country as COU', function ($join) {
                $join->on('CON.id', '=', 'COU.id_continent')
                    ->where('COU.name', 'COLOMBIA');
            })
            ->join('state as S', function ($join) use ($state) {
                $join->on('COU.id', '=', 'S.id_country')
                    ->where('S.consecutive', $state);
            })
            ->join('municipality as M', function ($join) use ($municipality) {
                $join->on('S.id', '=', 'M.id_state')
                    ->where('M.consecutive', $municipality);
            })
            ->where('CON.name', 'AMERICA')
            ->first();

        return $municipality ? $municipality->id : null;
    }

    public static function getAllMunicipalitiesByState($idState)
    {
        return DB::table('municipality')
            ->select('id', 'name')
            ->where('id_state', $idState)
            ->get();
    }
}
