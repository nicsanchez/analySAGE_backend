<?php

namespace App\Imports;

use App\AO\AcceptanceType\AcceptanceTypeAO;
use App\AO\Gender\GenderAO;
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
        $storeInscribedRequests = new StoreInscribed();
        foreach ($rows as $row) {
            $cont += 1;
            if ($row->filter()->isNotEmpty() and $cont != 1) {

                $dataPersonalInformation = [
                    'identification' => $row[0],
                    'birth_date' => Shared\Date::excelToDateTimeObject($row[1])->format('Y-m-d'),
                    'id_gender' => $row[2],
                    'id_birth_municipality' => $row[3],
                    'id_residence_municipality' => $row[4],
                    'id_stratum' => $row[5],
                    'id_school' => $row[6],
                    'year_of_degree' => $row[7],
                ];

                $dataPresentation = [
                    'registration_date' => Shared\Date::excelToDateTimeObject($row[8])->format('Y-m-d H:i:s'),
                    'credential' => $row[9],
                    'id_first_option_program' => $row[10],
                    'id_second_option_program' => $row[11],
                    'id_registration_type' => $row[12],
                    'id_semester' => $row[13],
                    'version' => $row[14],
                    'day_session' => $row[15],
                    //'' => $row[16], // pendiente de augusto que pregunte
                    'admitted' => $row[17],
                    'id_acceptance_type' => $row[18],
                    'id_accepted_program' => $row[19],
                ];
                $validator = Validator::make(array_merge($dataPersonalInformation, $dataPresentation),
                    $storeInscribedRequests->rules(),
                    $storeInscribedRequests->messages());

                if ($validator->fails()) {
                    self::$errors[] = ['row' => $cont, 'error' => $validator->errors()->all()];
                } else {
                    $dataPersonalInformation['id_gender'] = GenderAO::findGenderId($dataPersonalInformation['id_gender'])[0]->id;
                    $dataPresentation['id_registration_type'] = RegistrationTypeAO::findRegistrationTypeId($dataPresentation['id_registration_type'])[0]->id;
                    if ($dataPresentation['id_acceptance_type']) {
                        $dataPresentation['id_acceptance_type'] = AcceptanceTypeAO::findAcceptanceTypeId($dataPresentation['id_acceptance_type'])[0]->id;
                    }
                    $semester = SemesterAO::findSemesterId($dataPresentation['id_semester']);
                    if ($semester) {
                        $dataPresentation['id_semester'] = $semester->id;
                    } else {
                        $dataPresentation['id_semester'] = SemesterAO::insertNewSemester(['name' => $dataPresentation['id_semester']]);
                    }
                    $dataPresentation['admitted'] = $dataPresentation['admitted'] === 'ADMITIDO' ? true : false;
                    $personalInfo = PersonalInformationAO::getPersonalDataByDocument($dataPersonalInformation['identification']);

                    if ($personalInfo->count() !== 0) {
                        $dataPersonalInformation['updated_at'] = date('Y-m-d H:i:s');
                        PersonalInformationAO::updatePersonalInformation($personalInfo[0]->id, $dataPersonalInformation);
                        $dataPresentation['id_personal_information'] = $personalInfo[0]->id;
                    } else {
                        $dataPersonalInformation['created_at'] = date('Y-m-d H:i:s');
                        $dataPersonalInformation['updated_at'] = date('Y-m-d H:i:s');
                        $dataPresentation['id_personal_information'] = PersonalInformationAO::storePersonalInformation($dataPersonalInformation);
                    }
                    $dataPresentation['created_at'] = date('Y-m-d H:i:s');
                    $dataPresentation['updated_at'] = date('Y-m-d H:i:s');
                    PresentationAO::storePresentation($dataPresentation);
                }
            }
        }
    }

}
