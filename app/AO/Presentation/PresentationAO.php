<?php

namespace App\AO\Presentation;

use DB;

class PresentationAO
{

    public static function getPresentationBySemesterAndPersonalInfo($semester, $personalInfoId)
    {
        return DB::table('presentation')->where('id_personal_information', $personalInfoId)
            ->where('id_semester', $semester)
            ->get();
    }

    public static function updatePresentation($dataPresentation, $id)
    {
        DB::table('presentation')
            ->where('id', $id)
            ->update($dataPresentation);
    }

    public static function storePresentation($data)
    {
        DB::table('presentation')->insert($data);
    }

    public static function findByCredentialSemester($semester, $credential)
    {
        return DB::table('presentation')
            ->select('id', 'day_session')
            ->where('id_semester', $semester)
            ->where('credential', $credential)
            ->first();
    }

    public static function semesterHaveMoreThanOnePresentations($semester)
    {
        $presentations = DB::table('presentation')
            ->select('id')
            ->where('id_semester', $semester)
            ->get();

        return ($presentations->count() > 0);
    }

    public static function getAdmittedOrUnAdmittedPeople($filters, $state, $orderBy)
    {
        $query = DB::table('presentation as p')
            ->join('answers as a', 'a.id_presentation', 'p.id')
            ->join('semester as s', 's.id', 'p.id_semester')
            ->join('personal_information as pi', 'pi.id', 'p.id_personal_information')
            ->join('stratum as st', 'st.id', 'pi.id_stratum')
            ->join('gender as g', 'g.id', 'pi.id_gender')
            ->join('program as prf', 'prf.id', 'p.id_first_option_program')
            ->join('faculty as ff', 'ff.id', 'prf.id_faculty')
            ->leftJoin('program as prs', 'prs.id', 'p.id_second_option_program')
            ->leftjoin('faculty as fs', 'fs.id', 'prs.id_faculty')
            ->leftJoin('program as pra', 'pra.id', 'p.id_accepted_program')
            ->leftJoin('faculty as af', 'af.id', 'pra.id_faculty')
            ->join('municipality as m', 'm.id', 'pi.id_residence_municipality')
            ->join('state as sta', 'sta.id', 'm.id_state')
            ->join('country as co', 'co.id', 'sta.id_country')
            ->join('continent as c', 'c.id', 'co.id_continent')
            ->join('school as sc', 'sc.id', 'pi.id_school')
            ->join('municipality as ms', 'ms.id', 'sc.id_municipality')
            ->join('state as stas', 'stas.id', 'ms.id_state')
            ->join('country as cos', 'cos.id', 'stas.id_country')
            ->join('continent as cs', 'cs.id', 'cos.id_continent')
            ->join('registration_type as rt', 'rt.id', 'p.id_registration_type')

            ->select(
                DB::raw('count(p.id) as count'),
                $orderBy.' as parameter'
            );

        $query->where('s.id', $filters['semester']);
        $query->where('p.admitted', $state);

        if ($filters['gender']) {
            $query->where('g.id', $filters['gender']);
        }

        if ($filters['journey']) {
            $query->where('p.day_session', $filters['journey']);
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

        if ($filters['schoolContinent']) {
            $query->where('cs.id', $filters['schoolContinent']);
        }

        if ($filters['schoolCountry']) {
            $query->where('cos.id', $filters['schoolCountry']);
        }

        if ($filters['schoolState']) {
            $query->where('stas.id', $filters['schoolState']);
        }

        if ($filters['schoolMunicipality']) {
            $query->where('ms.id', $filters['schoolMunicipality']);
        }

        if ($filters['property']) {
            if ($state == 1) {
                $query->where('af.name', $filters['property']);
            } else {
                $query->where('ff.name', $filters['property']);
            }
        }

        $query->groupBy($orderBy);
        $query->orderBy($orderBy, 'ASC');

        return $query->get()->toArray();
    }

    public static function getAverageExamComponent($filters, $selectAverage, $orderBy)
    {
        $query = DB::table('presentation as p')
            ->join('semester as s', 's.id', 'p.id_semester')
            ->join('personal_information as pi', 'pi.id', 'p.id_personal_information')
            ->join('stratum as st', 'st.id', 'pi.id_stratum')
            ->join('gender as g', 'g.id', 'pi.id_gender')
            ->join('program as prf', 'prf.id', 'p.id_first_option_program')
            ->join('faculty as ff', 'ff.id', 'prf.id_faculty')
            ->leftJoin('program as prs', 'prs.id', 'p.id_second_option_program')
            ->leftjoin('faculty as fs', 'fs.id', 'prs.id_faculty')
            ->leftJoin('program as pra', 'pra.id', 'p.id_accepted_program')
            ->leftJoin('faculty as af', 'af.id', 'pra.id_faculty')
            ->join('municipality as m', 'm.id', 'pi.id_residence_municipality')
            ->join('state as sta', 'sta.id', 'm.id_state')
            ->join('country as co', 'co.id', 'sta.id_country')
            ->join('continent as c', 'c.id', 'co.id_continent')
            ->join('school as sc', 'sc.id', 'pi.id_school')
            ->join('municipality as ms', 'ms.id', 'sc.id_municipality')
            ->join('state as stas', 'stas.id', 'ms.id_state')
            ->join('country as cos', 'cos.id', 'stas.id_country')
            ->join('continent as cs', 'cs.id', 'cos.id_continent')
            ->join('registration_type as rt', 'rt.id', 'p.id_registration_type')

            ->select(
                DB::raw('round(avg('.$selectAverage.'),2) as count'),
                $orderBy.' as parameter'
            );

        $query->where('s.id', $filters['semester']);
        $query->whereNotNull($selectAverage);

        if ($filters['gender']) {
            $query->where('g.id', $filters['gender']);
        }

        if ($filters['journey']) {
            $query->where('p.day_session', $filters['journey']);
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

        if ($filters['schoolContinent']) {
            $query->where('cs.id', $filters['schoolContinent']);
        }

        if ($filters['schoolCountry']) {
            $query->where('cos.id', $filters['schoolCountry']);
        }

        if ($filters['schoolState']) {
            $query->where('stas.id', $filters['schoolState']);
        }

        if ($filters['schoolMunicipality']) {
            $query->where('ms.id', $filters['schoolMunicipality']);
        }

        if ($filters['property']) {
            $query->where('ff.name', $filters['property']);
        }

        $query->groupBy($orderBy);
        $query->orderBy($orderBy, 'ASC');

        return $query->get()->toArray();
    }
}
