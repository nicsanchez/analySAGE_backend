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

    public static function getQuestionsAmountBySemesterAndSession($semester)
    {
        return DB::table('questions')
            ->select(
                DB::raw('count(id) as count'),
                'day_session'
                )
            ->where('id_semester', $semester)
            ->groupBy('day_session')
            ->get()
            ->toArray();
    }

    public static function getMinJourney($semester)
    {
        $journey = DB::table('questions')
                ->select('day_session')
                ->whereRaw('day_session = (select min(`day_session`) from questions)')
                ->where('id_semester', $semester)
                ->first();
        return ($journey ? $journey->day_session : null);
    }

}
