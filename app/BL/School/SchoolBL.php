<?php

namespace App\BL\School;

use Log;
use App\BL\Logs\LogsBL;
use App\Imports\SchoolBulk;
use Maatwebsite\Excel\Facades\Excel;

class SchoolBL
{

    public static function storeSchools($request)
    {
        $response['status'] = 400;
        try {
            $schoolList = new SchoolBulk();
            Excel::import($schoolList, $request->file);
            $response['errors'] = $schoolList::$errors;
            $response['status'] = 200;
            LogsBL::saveLog('Colegios', 'Se ha almacenado la información de colegios.');
        } catch (\Throwable $th) {
            $response['msg'] = "No fue posible almacenar la información de los colegios.";
            Log::error('No fue posible almacenar la información de los colegios | E: ' .
                $th->getMessage() . ' | L: ' . $th->getLine() . ' | F:' . $th->getFile());
        }
        return $response;
    }
}
