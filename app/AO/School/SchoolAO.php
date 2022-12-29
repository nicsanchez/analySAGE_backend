<?php

namespace App\AO\School;

use DB;

class SchoolAO
{
    public static function getSchoolByCodeAndMunicipalityId($code, $municipalityId)
    {
        $school = DB::table('school')
                ->select('id')
                ->where('consecutive', $code)
                ->where('id_municipality', $municipalityId)
                ->first();
        return $school ? $school->id : null;
    }

    public static function getSchoolByCode($code)
    {
        $school = DB::table('school')
                ->select('id')
                ->where('consecutive', $code)
                ->first();
        return $school ? $school->id : null;
    }

    public static function storeSchool($data)
    {
        DB::table('school')->insert($data);
    }

    public static function updateSchool($data, $idSchool)
    {
        DB::table('school')->where('id', $idSchool)->update($data);
    }

    public static function getAllNaturalness()
    {
        return DB::table('school')
            ->select('naturalness')
            ->distinct()
            ->get();
    }

    public static function getAllSchoolsByNaturalnessAndLocation($filters)
    {
        $query = DB::table('school as sc')
            ->join('municipality as m', 'm.id', 'sc.id_municipality')
            ->join('state as sta', 'sta.id', 'm.id_state')
            ->join('country as co', 'co.id', 'sta.id_country')
            ->join('continent as c', 'c.id', 'co.id_continent')
            ->select('sc.id', 'sc.name');

        if ($filters['naturalness']) {
            $query->where('naturalness', $filters['naturalness']);
        }

        if ($filters['idContinent']) {
            $query->where('c.id', $filters['idContinent']);
        }

        if ($filters['idCountry']) {
            $query->where('co.id', $filters['idCountry']);
        }

        if ($filters['idState']) {
            $query->where('sta.id', $filters['idState']);
        }

        if ($filters['idMunicipality']) {
            $query->where('m.id', $filters['idMunicipality']);
        }

        return $query->get();
    }
}
