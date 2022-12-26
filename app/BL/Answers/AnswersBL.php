<?php

namespace App\BL\Answers;

use Log;
use App\BL\Logs\LogsBL;
use App\AO\Answers\AnswersAO;
use App\AO\Semester\SemesterAO;
use App\AO\Questions\QuestionsAO;
use App\Imports\AnswersBulkImport;
use Maatwebsite\Excel\Facades\Excel;

class AnswersBL
{

    public static function storeAnswers($request)
    {
        $response['status'] = 400;
        try {
            $answersList = new AnswersBulkImport($request->semester);
            Excel::import($answersList, $request->file);
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

    public static function getRightAndBadAnswersQuantity($request)
    {
        $response['status'] = 400;
        try {
            if (!$request['semester']) {
                $request['semester'] = SemesterAO::getMaxSemesterId();
            }

            if (!$request['journey']) {
                $request['journey'] = QuestionsAO::getMinJourney($request['semester']);
            }
            $response['right'] = AnswersAO::getRightAndBadAnswersQuantity($request, '=');
            $response['bad'] = AnswersAO::getRightAndBadAnswersQuantity($request, '<>');
            dd($response);
            $response['status'] = 200;
        } catch (\Throwable $th) {
            $response['msg'] = "No fue obtener datos para el grafo de estadisticas por pregunta.";
            Log::error('No fue obtener datos para el grafo de estadisticas por pregunta. | E: ' .
                $th->getMessage() . ' | L: ' . $th->getLine() . ' | F:' . $th->getFile());
        }
        return $response;
    }
}
