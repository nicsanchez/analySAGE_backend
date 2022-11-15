<?php

namespace App\AO\Questions;

use DB;

class QuestionsAO
{
    public static function storeQuestions($data)
    {
        DB::table('questions')->insert($data);
    }

    public static function getRightQuestions($semester)
    {
        return DB::table('questions')->select('id', 'right_answer', 'number', 'day_session')
            ->where('id_semester', $semester)
            ->orderBy('number', 'ASC')
            ->get();
    }
}
