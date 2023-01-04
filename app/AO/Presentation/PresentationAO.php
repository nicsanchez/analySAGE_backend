<?php

namespace App\AO\Presentation;

use DB;

class PresentationAO
{
    public static $data = [
        'gender' => 'g.id',
        'journey' => 'p.day_session',
        'stratum' => 'st.id',
        'firstOptionProgram' => 'prf.id',
        'secondOptionProgram' => 'prs.id',
        'firstOptionFaculty' => 'ff.id',
        'secondOptionFaculty' => 'fs.id',
        'continent' => 'c.id',
        'country' => 'co.id',
        'state' => 'sta.id',
        'municipality' => 'm.id',
        'schoolNaturalness' => 'sc.naturalness',
        'school' => 'sc.id',
        'schoolContinent' => 'cs.id',
        'schoolCountry' => 'cos.id',
        'schoolState' => 'stas.id',
        'schoolMunicipality' => 'ms.id',
        'semester' => 's.id'
    ];

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

    public static function getAdmittedOrUnAdmittedPeople($request, $state, $orderBy)
    {
        $filters = $request->all();
        $filterKeys = array_keys($filters);

        $query = self::getCommonRelationShipsByStatisticsQuery();
        $query->join('answers as a', 'a.id_presentation', 'p.id');
        $query->select(
            DB::raw('count(p.id) as count'),
            $orderBy.' as parameter'
        );

        $query->where('p.admitted', $state);

        foreach ($filterKeys as $key) {
            if ($filters[$key] && array_key_exists($key, self::$data)) {
                $query->where(self::$data[$key], $filters[$key]);
            }
        }

        if ($request['property']) {
            if ($state == 1) {
                $query->where('af.name', $request['property']);
            } else {
                $query->where('ff.name', $request['property']);
            }
        }

        $query->groupBy($orderBy);
        $query->orderBy($orderBy, 'ASC');

        return $query->get()->toArray();
    }

    public static function getAverageExamComponent($request, $selectAverage, $orderBy)
    {
        $filters = $request->all();
        $filterKeys = array_keys($filters);

        $query = self::getCommonRelationShipsByStatisticsQuery();
        $query->select(
            DB::raw('round(avg('.$selectAverage.'),2) as count'),
            $orderBy.' as parameter'
        );

        $query->whereNotNull($selectAverage);

        foreach ($filterKeys as $key) {
            if ($filters[$key] && array_key_exists($key, self::$data)) {
                $query->where(self::$data[$key], $filters[$key]);
            }
        }

        if ($request['property']) {
            $query->where('ff.name', $request['property']);
        }

        $query->groupBy($orderBy);
        $query->orderBy($orderBy, 'ASC');

        return $query->get()->toArray();
    }

    public static function getCommonRelationShipsByStatisticsQuery()
    {
        return DB::table('presentation as p')
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
            ->join('registration_type as rt', 'rt.id', 'p.id_registration_type');
    }
}
