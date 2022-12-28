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

    public static function updateAnswers($data,  $idAnswers)
    {
        DB::table('answers')->where('id', $idAnswers)->update($data);
    }

    public static function getRightAndBadAnswersQuantity($filters, $operator, $orderBy)
    {
        $query = DB::table('answers as a')
            ->join('presentation as p', 'p.id', 'a.id_presentation')
            ->join('semester as s', 's.id', 'p.id_semester')
            ->join('personal_information as pi', 'pi.id', 'p.id_personal_information')
            ->join('stratum as st', 'st.id', 'pi.id_stratum')
            ->join('gender as g', 'g.id', 'pi.id_gender')
            ->join('program as prf', 'prf.id', 'p.id_first_option_program')
            ->join('faculty as ff', 'ff.id', 'prf.id_faculty')
            ->leftJoin('program as prs', 'prs.id', 'p.id_second_option_program')
            ->leftjoin('faculty as fs', 'fs.id', 'prs.id_faculty')
            ->join('municipality as m', 'm.id', 'pi.id_residence_municipality')
            ->join('state as sta', 'sta.id', 'm.id_state')
            ->join('country as co', 'co.id', 'sta.id_country')
            ->join('continent as c', 'c.id', 'co.id_continent')
            ->join('school as sc', 'sc.id', 'pi.id_school')
            ->join('questions as q', function ($join) use ($filters) {
                $join->on('q.id_semester', '=', 's.id')
                    ->where('q.day_session', '=', $filters['journey']);
            })
            ->select(
                DB::raw('count(a.id) as count'),
                $orderBy.' as parameter'
            );

        $query->where('s.id', $filters['semester']);
        $query->where('p.day_session', $filters['journey']);
        $query->whereRaw('SUBSTRING(a.answers_marked, q.number, 1) '.$operator.' q.right_answer');

        if ($filters['gender']) {
            $query->where('g.id', $filters['gender']);
        }

        if ($filters['stratum']) {
            $query->where('st.id', $filters['stratum']);
        }

        if ($filters['firstOptionProgram']) {
            $query->where('prf.id', $filters['firstOptionProgram']);
        }

        if ($filters['secondOptionProgram']) {
            $query->where('prs.id', $filters['secondOptionProgram']);
        }

        if ($filters['firstOptionFaculty']) {
            $query->where('ff.id', $filters['firstOptionFaculty']);
        }

        if ($filters['secondOptionFaculty']) {
            $query->where('fs.id', $filters['secondOptionFaculty']);
        }

        if ($filters['continent']) {
            $query->where('c.id', $filters['continent']);
        }

        if ($filters['country']) {
            $query->where('co.id', $filters['country']);
        }

        if ($filters['state']) {
            $query->where('sta.id', $filters['state']);
        }

        if ($filters['municipality']) {
            $query->where('m.id', $filters['municipality']);
        }

        if ($filters['schoolNaturalness']) {
            $query->where('sc.naturalness', $filters['schoolNaturalness']);
        }

        if ($filters['school']) {
            $query->where('sc.id', $filters['school']);
        }

        if ($filters['questionNumber']) {
            $query->where('q.number', $filters['questionNumber']);
        }

        $query->groupBy($orderBy);
        $query->orderBy($orderBy, 'ASC');

        return $query->get()->toArray();
    }

}
