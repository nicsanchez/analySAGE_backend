<?php

namespace App\BL\Answers;

use App\BL\Logs\LogsBL;
use App\Imports\AnswersBulkImport;
use Log;
use Maatwebsite\Excel\Facades\Excel;

class AnswersBL
{

    public static function storeAnswers($file)
    {
        $response['status'] = 400;
        try {
            $answersList = new AnswersBulkImport;
            Excel::import($answersList, $file);
            $response['errors'] = $answersList::$errors;
            $response['status'] = 200;
            LogsBL::saveLog('Respuestas', 'Se ha almacenado la información de respuestas.');
        } catch (\Throwable $th) {
            $response['msg'] = "No fue posible almacenar la información de respuestas.";
            Log::error('No fue posible almacenar la información de respuestas | E: ' .
                $th->getMessage() . ' | L: ' . $th->getLine() . ' | F:' . $th->getFile());
        }
        return $response;
    }
}
