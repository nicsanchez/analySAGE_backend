<?php

namespace App\BL\Questions;

use App\BL\Logs\LogsBL;
use App\Imports\QuestionsBulkImport;
use Log;
use Maatwebsite\Excel\Facades\Excel;

class QuestionsBL
{

    public static function storeQuestions($file)
    {
        $response['status'] = 400;
        try {
            $questionsList = new QuestionsBulkImport;
            Excel::import($questionsList, $file);
            $response['errors'] = $questionsList::$errors;
            $response['status'] = 200;
            LogsBL::saveLog('Preguntas', 'Se ha almacenado la información de las preguntas.');
        } catch (\Throwable $th) {
            $response['msg'] = "No fue posible almacenar la información de las preguntas.";
            Log::error('No fue posible almacenar la información de las preguntas | E: ' .
                $th->getMessage() . ' | L: ' . $th->getLine() . ' | F:' . $th->getFile());
        }
        return $response;
    }
}
