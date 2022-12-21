<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\AO\Municipality\MunicipalityAO;
use App\AO\School\SchoolAO;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\School\SchoolBulkRequest;

class SchoolBulk implements ToCollection
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
                    $idMunicipality = MunicipalityAO::getMunicipalityIdToColombiansMunicipality($row[3], $row[2]);
                    if ($idMunicipality) {
                        $this->validateSchoolExistanceAndStoreOrUpdateIt($row[0], $row[1], $idMunicipality, $row[6]);
                    } else {
                        self::$errors[] = [
                            'row' => $cont,
                            'error' => ['No existe el municipio relacionado al colegio en base de datos.']
                        ];
                    }
                }
            }
        }
    }

    public function validateSchoolExistanceAndStoreOrUpdateIt($code, $name, $idMunicipality, $naturalness)
    {
        $idSchool = SchoolAO::getSchoolByCode($code);
        $data = [
            'name' => $name,
            'consecutive' => $code,
            'id_municipality' => $idMunicipality,
            'naturalness' => $naturalness,
            'created_at' => $this->now,
            'updated_at' => $this->now
        ];
        if ($idSchool) {
            unset($data['created_at']);
            SchoolAO::updateSchool($data, $idSchool);
        } else {
            SchoolAO::storeSchool($data);
        }
    }

    public function validateRowInExcelAndReturnValidator($row)
    {
        $schoolBulkRequest = new SchoolBulkRequest();
        $data = [
            'schoolCode' => $row[0],
            'schoolName' => $row[1],
            'stateCode' => $row[3],
            'stateName' => $row[5],
            'municipalityCode' => $row[2],
            'municipalityName' => $row[4],
            'naturalness' => $row[6],
        ];
        return Validator::make($data, $schoolBulkRequest->rules(), $schoolBulkRequest->messages());
    }
}
