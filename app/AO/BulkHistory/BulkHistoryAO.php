<?php

namespace App\AO\BulkHistory;

use DB;

class BulkHistoryAO
{
    public static function insertHistory($data)
    {
        DB::table('bulk_history')->insert($data);
    }

    public static function updateHistory($idSemester, $data)
    {
        DB::table('bulk_history')->where('id_semester', $idSemester)->update($data);
    }

    public static function existHistory($idSemester)
    {
        $history = DB::table('bulk_history')->where('id_semester', $idSemester)->get();
        return ($history->count() > 0);
    }

    public static function existInscribedHistory($idSemester)
    {
        $history = DB::table('bulk_history')->where('id_semester', $idSemester)->where('inscribed', 1)->get();
        return ($history->count() > 0);
    }

    public static function existQuestionHistory($idSemester)
    {
        $history = DB::table('bulk_history')->where('id_semester', $idSemester)->where('questions', 1)->get();
        return ($history->count() > 0);
    }
}
