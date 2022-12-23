<?php

namespace App\AO\Answers;

use DB;

class AnswersAO
{
    public static function storeAnswers($data)
    {
        DB::table('answers')->insert($data);
    }

    public static function credentialHaveAnswersInSemester($presentationId)
    {
        $answer = DB::table('answers')
            ->where('id_presentation', $presentationId)
            ->first();
        return $answer ? $answer->id : null;
    }

    public static function updateAnswers($data, $idAnswers)
    {
        DB::table('answers')->where('id', $idAnswers)->update($data);
    }
}
