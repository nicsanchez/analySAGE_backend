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

    public static function semesterHaveMoreThanOneQuestion($semester)
    {
        $questions = DB::table('questions')
            ->select('id')
            ->where('id_semester', $semester)
            ->get();

        return ($questions->count() > 0);
    }

    public static function semesterHaveQuestions($semester)
    {
        $questions = DB::table('questions')
            ->where('id_semester', $semester)
            ->get();
        return ($questions->count() > 0);
    }

    public static function deleteQuestionsInSemester($semester)
    {
        DB::table('questions')->where('id_semester', $semester)->delete();
    }
}
