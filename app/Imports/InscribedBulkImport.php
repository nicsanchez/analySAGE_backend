<?php

namespace App\Imports;

use App\AO\AcceptanceType\AcceptanceTypeAO;
use App\AO\Gender\GenderAO;
use App\AO\Municipality\MunicipalityAO;
use App\AO\PersonalInformation\PersonalInformationAO;
use App\AO\Presentation\PresentationAO;
use App\AO\RegistrationType\RegistrationTypeAO;
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
    public static $errors = [];

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
            'id_semester' => $row[19],
            'version' => $row[20],
            'day_session' => $row[21],
            //'' => $row[22], // pendiente de augusto que pregunte
            'admitted' => $row[23],
            'id_acceptance_type' => $row[24],
            'id_accepted_program' => $row[25],
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
        $dataPresentation = $this->insertNewSemesterIfNotExists($dataPresentation);
        $dataPresentation['admitted'] = $dataPresentation['admitted'] === 'ADMITIDO' ? true : false;
        return $dataPresentation;
    }

    public function insertNewSemesterIfNotExists($dataPresentation)
    {
        $semester = SemesterAO::findSemesterId($dataPresentation['id_semester']);
        if ($semester) {
            $dataPresentation['id_semester'] = $semester->id;
        } else {
            $dataPresentation['id_semester'] = SemesterAO::insertNewSemester(
                ['name' => $dataPresentation['id_semester']]
            );
        }
        return $dataPresentation;
    }
}
