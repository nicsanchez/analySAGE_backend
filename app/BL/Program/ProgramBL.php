<?php

namespace App\BL\Program;

use Log;
use App\BL\Logs\LogsBL;
use App\AO\Program\ProgramAO;
use App\Imports\ProgramBulk;
use Maatwebsite\Excel\Facades\Excel;

class ProgramBL
{

    public static function storePrograms($request)
    {
        $response['status'] = 400;
        try {
            $programList = new ProgramBulk();
            Excel::import($programList, $request->file);
            $response['errors'] = $programList::$errors;
            $response['status'] = 200;
            LogsBL::saveLog('Programas', 'Se ha almacenado la información de los programas.');
        } catch (\Throwable $th) {
            $response['msg'] = "No fue posible almacenar la información de los programas.";
            Log::error('No fue posible almacenar la información de los programas | E: ' .
                $th->getMessage() . ' | L: ' . $th->getLine() . ' | F:' . $th->getFile());
        }
        return $response;
    }

    public static function getProgramsByFaculty($idFaculty)
    {
        $response['status'] = 400;
        try {
            $response['data'] = ProgramAO::getProgramsByFaculty($idFaculty);
            $response['status'] = 200;
        } catch (\Throwable $th) {
            $response['msg'] = "No fue posible obtener los programas del sistema.";
            Log::error('No fue posible obtener los programas del sistema. | E: ' .
                $th->getMessage() . ' | L: ' . $th->getLine() . ' | F:' . $th->getFile());
        }
        return $response;
    }
}
