<?php

namespace App\Imports;

use App\AO\AcceptanceType\AcceptanceTypeAO;
use App\AO\BulkHistory\BulkHistoryAO;
use App\AO\Gender\GenderAO;
use App\AO\Municipality\MunicipalityAO;
use App\AO\PersonalInformation\PersonalInformationAO;
use App\AO\Presentation\PresentationAO;
use App\AO\Program\ProgramAO;
use App\AO\RegistrationType\RegistrationTypeAO;
use App\AO\School\SchoolAO;
use App\AO\Semester\SemesterAO;
use App\Http\Requests\Inscribed\StoreInscribed;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use \PhpOffice\PhpSpreadsheet\Shared as Shared;

class InscribedBulkImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public static $semester = null;
    public static $errors = [];

    public function __construct($semester)
    {
        $this->insertNewSemesterIfNotExists($semester);
    }

    public function collection($rows)
    {
        $cont = 0;
        foreach ($rows as $row) {
            $cont += 1;
            if ($row->filter()->isNotEmpty() && $cont != 1) {
                $validationData = $this->validateRow($row);
                $validator = $validationData['validation'];
                $dataPersonalInformation = $validationData['dataPersonalInformation'];
                $dataPresentation = $validationData['dataPresentation'];
                if ($validator->fails()) {
                    self::$errors[] = ['row' => $cont, 'error' => $validator->errors()->all()];
                } else {
                    $dataPersonalInformation = $this->processPersonalInformationIds($dataPersonalInformation, $cont);
                    if ($dataPersonalInformation === 'Not found') {
                        continue;
                    }
                    $dataPresentation = $this->processPresentationIds($dataPresentation, $cont);
                    if ($dataPresentation === 'Not found') {
                        continue;
                    }
                    $personalInfo = PersonalInformationAO::getPersonalDataByDocument(
                        $dataPersonalInformation['identification']);

                    if ($personalInfo->count() !== 0) {
                        $this->updatePersonalInformation($dataPersonalInformation, $personalInfo);
                        $dataPresentation['id_personal_information'] = $personalInfo[0]->id;
                    } else {
                        $dataPresentation['id_personal_information'] = $this->storePersonalInformation(
                            $dataPersonalInformation);
                    }
                    $this->storePresentation($dataPresentation);
                }
            }
        }
        $this->storeLogFromInscribedBulk();
    }

    public function processPersonalInformationIds($dataPersonalInformation, $cont)
    {
        $dataPersonalInformation['id_gender'] = GenderAO::findGenderId(
            $dataPersonalInformation['id_gender'])[0]->id;
        $dataPersonalInformation['id_birth_municipality'] = MunicipalityAO::findMunicipalityId(
            $dataPersonalInformation['id_birth_continent'],
            $dataPersonalInformation['id_birth_country'],
            $dataPersonalInformation['id_birth_state'],
            $dataPersonalInformation['id_birth_municipality']
        )[0]->id;
        $dataPersonalInformation['id_residence_municipality'] = MunicipalityAO::findMunicipalityId(
            $dataPersonalInformation['id_residence_continent'],
            $dataPersonalInformation['id_residence_country'],
            $dataPersonalInformation['id_residence_state'],
            $dataPersonalInformation['id_residence_municipality']
        )[0]->id;
        $schoolId = SchoolAO::getSchoolByCode($dataPersonalInformation['id_school']);
        if (!$schoolId) {
            self::$errors[] = ['row' => $cont, 'error' => 'El colegio con Id ' . $dataPersonalInformation['id_school'] .
                "no está registrado en el sistema."];
            $dataPersonalInformation = 'Not found';
        } else {
            $dataPersonalInformation['id_school'] = $schoolId;
        }

        return $dataPersonalInformation;
    }

    public function storePresentation($dataPresentation)
    {
        $dataPresentation['created_at'] = date('Y-m-d H:i:s');
        $dataPresentation['updated_at'] = date('Y-m-d H:i:s');
        PresentationAO::storePresentation($dataPresentation);
    }

    public function storePersonalInformation($dataPersonalInformation)
    {
        $dataPersonalInformation['created_at'] = date('Y-m-d H:i:s');
        $dataPersonalInformation['updated_at'] = date('Y-m-d H:i:s');
        $dataPersonalInformation = $this->unsetNotUsedData($dataPersonalInformation);
        return PersonalInformationAO::storePersonalInformation($dataPersonalInformation);
    }

    public function updatePersonalInformation($dataPersonalInformation, $personalInfo)
    {
        $dataPersonalInformation['updated_at'] = date('Y-m-d H:i:s');
        $dataPersonalInformation = $this->unsetNotUsedData($dataPersonalInformation);
        PersonalInformationAO::updatePersonalInformation($personalInfo[0]->id, $dataPersonalInformation);
    }

    public function unsetNotUsedData($dataPersonalInformation)
    {
        unset($dataPersonalInformation['id_birth_continent']);
        unset($dataPersonalInformation['id_birth_country']);
        unset($dataPersonalInformation['id_birth_state']);
        unset($dataPersonalInformation['id_residence_continent']);
        unset($dataPersonalInformation['id_residence_country']);
        unset($dataPersonalInformation['id_residence_state']);
        return $dataPersonalInformation;
    }

    public function validateRow($row)
    {
        $storeInscribedRequests = new StoreInscribed();

        $data['dataPersonalInformation'] = [
            'identification' => $row[0],
            'birth_date' => Shared\Date::excelToDateTimeObject($row[1])->format('Y-m-d'),
            'id_gender' => $row[2],
            'id_birth_continent' => $row[3],
            'id_birth_country' => $row[4],
            'id_birth_state' => $row[5],
            'id_birth_municipality' => $row[6],
            'id_residence_continent' => $row[7],
            'id_residence_country' => $row[8],
            'id_residence_state' => $row[9],
            'id_residence_municipality' => $row[10],
            'id_stratum' => $row[11],
            'id_school' => $row[12],
            'year_of_degree' => $row[13],
        ];

        $data['dataPresentation'] = [
            'registration_date' => Shared\Date::excelToDateTimeObject($row[14])->format('Y-m-d H:i:s'),
            'credential' => $row[15],
            'id_first_option_program' => $row[16],
            'id_second_option_program' => $row[17],
            'id_registration_type' => $row[18],
            'id_semester' => self::$semester,
            'version' => $row[19],
            'day_session' => $row[20],
            //'' => $row[21], // pendiente de augusto que pregunte
            'admitted' => $row[22],
            'id_acceptance_type' => $row[23],
            'id_accepted_program' => $row[24],
        ];

        $data['validation'] = Validator::make(
            array_merge($data['dataPersonalInformation'], $data['dataPresentation']),
            $storeInscribedRequests->rules(),
            $storeInscribedRequests->messages());
        return $data;
    }

    public function processPresentationIds($dataPresentation, $cont)
    {
        $dataPresentation['id_registration_type'] = RegistrationTypeAO::findRegistrationTypeId(
            $dataPresentation['id_registration_type'])[0]->id;
        if ($dataPresentation['id_acceptance_type']) {
            $dataPresentation['id_acceptance_type'] = AcceptanceTypeAO::findAcceptanceTypeId(
                $dataPresentation['id_acceptance_type'])[0]->id;
        }
        $dataPresentation['admitted'] = $dataPresentation['admitted'] === 'ADMITIDO' ? true : false;
        if ($dataPresentation['id_second_option_program']) {
            $dataPresentation = $this->findProgramId($dataPresentation, 'id_second_option_program', $cont);
        }
        if ($dataPresentation['id_first_option_program']) {
            if ($dataPresentation !== 'Not found') {
                $dataPresentation = $this->findProgramId($dataPresentation, 'id_first_option_program', $cont);
            }
        }
        if ($dataPresentation['id_accepted_program']) {
            if ($dataPresentation !== 'Not found') {
                $dataPresentation = $this->findProgramId($dataPresentation, 'id_accepted_program', $cont);
            }
        }
        return $dataPresentation;
    }

    public function findProgramId($data, $field, $cont)
    {
        $idProgram = ProgramAO::getProgramByCode($data[$field]);
        if (!$idProgram) {
            self::$errors[] = ['row' => $cont, 'error' => 'El programa con Id ' . $data[$field] .
                "no está registrado en el sistema."];
            $data = 'Not found';
        } else {
            $data[$field] = $idProgram;
        }
        return $data;
    }

    public function insertNewSemesterIfNotExists($semester)
    {
        $objSemester = SemesterAO::findSemesterId($semester);
        if ($objSemester) {
            self::$semester = $objSemester->id;
        } else {
            self::$semester = SemesterAO::insertNewSemester(
                ['name' => $semester]
            );
        }
    }

    public function storeLogFromInscribedBulk()
    {
        if (PresentationAO::semesterHaveMoreThanOnePresentations(self::$semester) &&
            !BulkHistoryAO::existHistory(self::$semester)) {
            $now = date('Y-m-d H:i:s');
            $data = [
                'id_semester' => self::$semester,
                'inscribed' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ];
            BulkHistoryAO::insertHistory($data);
        }
    }
}
