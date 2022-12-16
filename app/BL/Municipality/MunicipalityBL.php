<?php

namespace App\BL\Municipality;

use Log;
use App\BL\Logs\LogsBL;
use App\Imports\MunicipalityBulk;
use Maatwebsite\Excel\Facades\Excel;

class MunicipalityBL
{

    public static function storeMunicipalities($request)
    {
        $response['status'] = 400;
        try {
            $municipalityList = new MunicipalityBulk();
            Excel::import($municipalityList, $request->file);
            $response['errors'] = $municipalityList::$errors;
            $response['status'] = 200;
            LogsBL::saveLog('Municipios', 'Se ha almacenado la información de municipios.');
        } catch (\Throwable $th) {
            $response['msg'] = "No fue posible almacenar la información de municipios.";
            Log::error('No fue posible almacenar la información de municipios | E: ' .
                $th->getMessage() . ' | L: ' . $th->getLine() . ' | F:' . $th->getFile());
        }
        return $response;
    }
}
