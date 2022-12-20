<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Program\ProgramBulkRequest;
use App\AO\Faculty\FacultyAO;
use App\AO\Headquarter\HeadquarterAO;
use App\AO\Program\ProgramAO;

class ProgramBulk implements ToCollection
{
    public static $errors = [];

    public function __construct()
    {
        $this->now = date('Y-m-d H:i:s');
    }

    /**
    * @param Collection $collection
    */
    public function collection($rows)
    {

        $cont = 0;
        foreach ($rows as $row) {
            $cont++;
            if ($row->filter()->isNotEmpty() && $cont != 1) {
                $validator = $this->validateRowInExcelAndReturnValidator($row);
                if ($validator->fails()) {
                    self::$errors[] = ['row' => $cont, 'error' => $validator->errors()->all()];
                } else {
                    $idFaculty = $this->validateFacultyExistanceAndReturnId($row[3], $row[4]);
                    $idHeadquarter = $this->validateHeadquarterExistanceAndReturnId($row[2]);
                    $this->validateProgramExistanceAndUpdateOrStoreIt($row[0], $row[1], $idFaculty, $idHeadquarter);
                }
            }
        }
    }

    public function validateFacultyExistanceAndReturnId($code, $name)
    {
        $idFaculty = FacultyAO::getFacultyByCode($code);
        $data = [
            'name' => $name,
            'consecutive' => $code,
            'created_at' => $this->now,
            'updated_at' => $this->now,
        ];
        if ($idFaculty) {
            unset($data['created_at']);
            FacultyAO::updateFaculty($data, $idFaculty);
        } else {
            $idFaculty = FacultyAO::storeFaculty($data);
        }

        return $idFaculty;
    }

    public function validateHeadquarterExistanceAndReturnId($name)
    {
        $idHeadquarter = HeadquarterAO::getHeadquarterByName($name);
        $data = [
            'name' => $name,
            'created_at' => $this->now,
            'updated_at' => $this->now,
        ];
        if ($idHeadquarter) {
            unset($data['created_at']);
            HeadquarterAO::updateHeadquarter($data, $idHeadquarter);
        } else {
            $idHeadquarter = HeadquarterAO::storeHeadquarter($data);
        }

        return $idHeadquarter;
    }

    public function validateProgramExistanceAndUpdateOrStoreIt($code, $name, $idFaculty, $idHeadquarter)
    {
        $idProgram = ProgramAO::getProgramByCode($code);
        $data = [
            'name' => $name,
            'consecutive' => $code,
            'id_headquaters' => $idHeadquarter,
            'id_faculty' => $idFaculty,
            'created_at' => $this->now,
            'updated_at' => $this->now,
        ];
        if ($idProgram) {
            unset($data['created_at']);
            ProgramAO::updateProgram($data, $idProgram);
        } else {
            ProgramAO::storeProgram($data);
        }
    }

    public function validateRowInExcelAndReturnValidator($row)
    {
        $programBulkRequest = new ProgramBulkRequest();
        $data = [
            'programCode' => $row[0],
            'programName' => $row[1],
            'headquarterName' => $row[2],
            'facultyCode' => $row[3],
            'facultyName' => $row[4]
        ];
        return Validator::make($data, $programBulkRequest->rules(), $programBulkRequest->messages());
    }
}
