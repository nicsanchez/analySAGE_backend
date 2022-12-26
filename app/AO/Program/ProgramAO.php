<?php

namespace App\AO\Program;

use DB;

class ProgramAO
{
    public static function getProgramByCode($code)
    {
        $program = DB::table('program')
                ->select('id')
                ->where('consecutive', $code)
                ->first();
        return $program ? $program->id : null;
    }

    public static function storeProgram($data)
    {
        DB::table('program')->insert($data);
    }

    public static function updateProgram($data, $idProgram)
    {
        DB::table('program')->where('id', $idProgram)->update($data);
    }

    public static function getAllPrograms()
    {
        return DB::table('program')
            ->select('id', 'name')
            ->get();
    }
}
