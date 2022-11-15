<?php

namespace App\Imports;

use App\AO\Questions\QuestionsAO;
use App\AO\Semester\SemesterAO;
use App\Http\Requests\Questions\StoreQuestions;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;

class QuestionsBulkImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public static $errors = [];

    public function collection($rows)
    {
        $cont = 0;
        $storeQuestionsRequests = new StoreQuestions();
        foreach ($rows as $row) {
            $cont += 1;
            if ($row->filter()->isNotEmpty() and $cont != 1) {
                $data = [
                    'id_semester' => $row[0],
                    'day_session' => $row[1],
                    'number' => $row[2],
                    'right_answer' => $row[3],
                ];
                $validator = Validator::make($data,
                    $storeQuestionsRequests->rules(),
                    $storeQuestionsRequests->messages());

                if ($validator->fails()) {
                    self::$errors[] = ['row' => $cont, 'error' => $validator->errors()->all()];
                } else {
                    $data['id_semester'] = SemesterAO::findSemesterId($data['id_semester'])->id;
                    $data['created_at'] = date('Y-m-d H:i:s');
                    $data['updated_at'] = date('Y-m-d H:i:s');
                    QuestionsAO::storeQuestions($data);
                }
            }
        }
    }

}
