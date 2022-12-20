<?php

namespace App\AO\Headquarter;

use DB;

class HeadquarterAO
{
    public static function getHeadquarterByName($name)
    {
        $headquarter = DB::table('headquarters')
                ->select('id')
                ->where('name', $name)
                ->first();
        return $headquarter ? $headquarter->id : null;
    }

    public static function storeHeadquarter($data)
    {
        return DB::table('headquarters')->insertGetId($data);
    }

    public static function updateHeadquarter($data, $idHeadquarter)
    {
        DB::table('headquarters')->where('id', $idHeadquarter)->update($data);
    }
}
