<?php

namespace App\BL\Inscribed;

use App\BL\Logs\LogsBL;
use Log;
use App\Imports\InscribedBulkImport;
use Maatwebsite\Excel\Facades\Excel;

class InscribedBL{

    public static function storeInscribedBySemester($file){
        $response['status'] = 400;
        try {
            $inscribedList = new InscribedBulkImport;
            Excel::import($inscribedList, $file);
            $response['errors'] = $inscribedList::$errors;
            $response['status'] = 200;
            LogsBL::saveLog('Inscritos','Se ha almacenado la información de inscritos en el servidor.');
        } catch (\Throwable $th) {
            $response['msg'] = "No fue posible almanecar la información de inscritos en el servidor.";
            Log::error('No fue posible almanecar la información de inscritos en el servidor | E: '.$th->getMessage().' | L: '.$th->getLine().' | F:'.$th->getFile());
        }
        return $response;
    }
}
