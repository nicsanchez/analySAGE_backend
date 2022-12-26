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

    public static function getAllSchoolsByNaturalnessAndMunicipality($naturalness, $idMunicipality)
    {
        $query = DB::table('school')
            ->select('id', 'name')
            ->where('id_municipality', $idMunicipality);

        if ($naturalness) {
            $query->where('naturalness', $naturalness);
        }

        return $query->get();
    }
}
