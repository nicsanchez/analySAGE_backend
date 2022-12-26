<?php

namespace App\BL\Country;

use Log;
use App\AO\Country\CountryAO;

class CountryBL
{

    public static function getAllCountriesByContinent($idContinent)
    {
        $response['status'] = 400;
        try {
            $response['data'] = CountryAO::getAllCountriesByContinent($idContinent);
            $response['status'] = 200;
        } catch (\Throwable $th) {
            $response['msg'] = "No fue posible obtener los paises del continente.";
            Log::error('No fue posible obtener los paises del continente. | E: ' .
                $th->getMessage() . ' | L: ' . $th->getLine() . ' | F:' . $th->getFile());
        }
        return $response;
    }
}
