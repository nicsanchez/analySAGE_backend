<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\AO\Continent\ContinentAO;
use App\AO\Country\CountryAO;
use App\AO\State\StateAO;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Municipality\MunicipalityBulkRequest;
use App\AO\Municipality\MunicipalityAO;

class MunicipalityBulk implements ToCollection
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
                    $idContinent = $this->validateContinentExistanceAndReturnId($row[0], $row[1]);
                    $idCountry = $this->validateCountryExistanceAndReturnId($row[2], $row[3], $idContinent);
                    $idState = $this->validateStateExistanceAndReturnId($row[4], $row[5], $idCountry);
                    $this->validateMunicipalityExistance($row[6], $row[7], $idState);
                }
            }
        }
    }

    public function validateContinentExistanceAndReturnId($code, $name)
    {
        $idContinent = ContinentAO::getContinentByCode($code);
        $data = [
            'name' => $name,
            'consecutive' => $code,
            'created_at' => $this->now,
            'updated_at' => $this->now,
        ];
        if ($idContinent) {
            unset($data['created_at']);
            ContinentAO::updateContinent($data, $idContinent);
        } else {
            $idContinent = ContinentAO::storeContinent($data);
        }

        return $idContinent;
    }

    public function validateCountryExistanceAndReturnId($code, $name, $continentId)
    {
        $idCountry = CountryAO::getCountryByCodeAndContinentId($code, $continentId);
        $data = [
            'name' => $name,
            'consecutive' => $code,
            'id_continent' => $continentId,
            'created_at' => $this->now,
            'updated_at' => $this->now,
        ];
        if ($idCountry) {
            unset($data['created_at']);
            CountryAO::updateCountry($data, $idCountry);
        } else {
            $idCountry = CountryAO::storeCountry($data);
        }

        return $idCountry;
    }

    public function validateStateExistanceAndReturnId($code, $name, $countryId)
    {
        $idState = StateAO::getStateByCodeAndCountryId($code, $countryId);
        $data = [
            'name' => $name,
            'consecutive' => $code,
            'id_country' => $countryId,
            'created_at' => $this->now,
            'updated_at' => $this->now,
        ];
        if ($idState) {
            unset($data['created_at']);
            StateAO::updateState($data, $idState);
        } else {
            $idState = StateAO::storeState($data);
        }

        return $idState;
    }

    public function validateMunicipalityExistance($code, $name, $stateId)
    {
        $idMunicipality = MunicipalityAO::getMunicipalityByCodeAndStateId($code, $stateId);
        $data = [
            'name' => $name,
            'consecutive' => $code,
            'id_state' => $stateId,
            'created_at' => $this->now,
            'updated_at' => $this->now,
        ];
        if ($idMunicipality) {
            unset($data['created_at']);
            MunicipalityAO::updateMunicipality($data, $idMunicipality);
        } else {
            MunicipalityAO::storeMunicipality($data);
        }
    }

    public function validateRowInExcelAndReturnValidator($row)
    {
        $municipalityBulkRequest = new MunicipalityBulkRequest();
        $data = [
            'continentCode' => $row[0],
            'continentName' => $row[1],
            'countryCode' => $row[2],
            'countryName' => $row[3],
            'stateCode' => $row[4],
            'stateName' => $row[5],
            'municipalityCode' => $row[6],
            'municipalityName' => $row[7],
        ];
        return Validator::make($data, $municipalityBulkRequest->rules(), $municipalityBulkRequest->messages());
    }
}
