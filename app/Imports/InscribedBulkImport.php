<?php

namespace App\Imports;

use App\AO\AcceptanceType\AcceptanceTypeAO;
use App\AO\BulkHistory\BulkHistoryAO;
use App\AO\Gender\GenderAO;
use App\AO\Municipality\MunicipalityAO;
use App\AO\PersonalInformation\PersonalInformationAO;
use App\AO\Presentation\PresentationAO;
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
                    $dataPersonalInformation = $this->processPersonalInformationIds($dataPersonalInformation);
                    $dataPresentation = $this->processPresentationIds($dataPresentation);
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

    public function processPersonalInformationIds($dataPersonalInformation)
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

        $dataPersonalInformation['id_school'] = $this->storeOrUpdateSchool($dataPersonalInformation);
        $dataPersonalInformatio['id_first_option_program'] = $this->storeOrUpdateProgram(
            $dataPersonalInformation['id_first_option_program'],
            $dataPersonalInformation['first_option_program_name']);
        $dataPersonalInformatio['id_second_option_program'] = $this->storeOrUpdateProgram(
            $dataPersonalInformation['id_second_option_program'],
            $dataPersonalInformation['second_option_program_name']);
        $dataPersonalInformatio['id_accepted_program'] = $this->storeOrUpdateProgram(
            $dataPersonalInformation['id_accepted_program'],
            $dataPersonalInformation['accepted_program_name']);

        return $dataPersonalInformation;
    }

    public function storeOrUpdateProgram($dataPersonalInformation)
    {

    }

    public function storeOrUpdateSchool($dataPersonalInformation)
    {
        $municipalityId = MunicipalityAO::findMunicipalityId(1, 46, $dataPersonalInformation['id_state_school'],
            $dataPersonalInformation['id_municipality_school']);
        $schoolId = SchoolAO::validateSchoolExistance($dataPersonalInformatio['id_school'],
            $dataPersonalInformation['school_name'], $municipalityId);
        $dataSchool = [
            'id_municipality' => $municipalityId,
            'consecutive' => $dataPersonalInformatio['id_school'],
            'name' => $dataPersonalInformation['school_name'],
            'naturalness' => $dataPersonalInformation['naturalness'],
        ];
        if ($schoolId) {
            SchoolAO::updateSchool($schoolId, $dataSchool);
        } else {
            $schoolId = SchoolAO::storeSchool($dataSchool);
        }
        return $schoolId;
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
        unset($dataPersonalInformation['school_name']);
        unset($dataPersonalInformation['id_state_school']);
        unset($dataPersonalInformation['id_municipality_school']);
        unset($dataPersonalInformation['naturalness']);
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
            'id_school' => $row[12], //Con columnas $row[12] $row[13] $row[15] $row[16] se obtiene colegio y se pone id aca

            'school_name' => $row[13],
            'id_state_school' => $row[14],
            'id_municipality_school' => $row[15],
            'naturalness' => $row[16],

            'year_of_degree' => $row[17],
        ];

        $data['dataPresentation'] = [
            'registration_date' => Shared\Date::excelToDateTimeObject($row[18])->format('Y-m-d H:i:s'),
            'credential' => $row[19],
            'id_first_option_program' => $row[20], // con las columnas $row[20] y $row[21] se saca programa primera opcion y se pone id

            'first_option_program_name' => $row[21],

            'id_second_option_program' => $row[22], // con las columnas $row[22] y $row[23] se saca programa segunda opcion y se pone id

            'second_option_program_name' => $row[23],

            'id_registration_type' => $row[24],
            'id_semester' => self::$semester,
            'version' => $row[25],
            'day_session' => $row[26],
            //'' => $row[27], // pendiente de augusto que pregunte
            'admitted' => $row[28],
            'id_acceptance_type' => $row[29],
            'id_accepted_program' => $row[30], // con las columnas $row[30] y $row[31] se saca programa admitido y se pone id

            'accepted_program_name' => $row[31],
        ];

        $data['validation'] = Validator::make(
            array_merge($data['dataPersonalInformation'], $data['dataPresentation']),
            $storeInscribedRequests->rules(),
            $storeInscribedRequests->messages());
        return $data;
    }

    public function processPresentationIds($dataPresentation)
    {
        $dataPresentation['id_registration_type'] = RegistrationTypeAO::findRegistrationTypeId(
            $dataPresentation['id_registration_type'])[0]->id;
        if ($dataPresentation['id_acceptance_type']) {
            $dataPresentation['id_acceptance_type'] = AcceptanceTypeAO::findAcceptanceTypeId(
                $dataPresentation['id_acceptance_type'])[0]->id;
        }
        $dataPresentation['admitted'] = $dataPresentation['admitted'] === 'ADMITIDO' ? true : false;
        return $dataPresentation;
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
