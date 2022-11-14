<?php

namespace App\AO\Answers;

use DB;

class AnswersAO
{
    public static function storeAnswers($data){
        DB::table('answers')->insert($data);
    }

    public static function issetCredentialInSemester($semesterId, $credential)
    {
        $answer = DB::table('answers as A')
            ->join('questions as Q', 'A.id_question', 'Q.id')
            ->join('presentation as P', 'P.id', 'A.id_presentation')
            ->where('P.credential', $credential)
            ->where('Q.id_semester', $semesterId)
            ->get();
        return ($answer->count() > 0);
    }

    public static function deleteAnswer($semesterId, $credential)
    {
        DB::table('answers as A')
            ->join('questions as Q', 'A.id_question', 'Q.id')
            ->join('presentation as P', 'P.id', 'A.id_presentation')
            ->where('P.credential', $credential)
            ->where('Q.id_semester', $semesterId)
            ->delete();
    }
}
