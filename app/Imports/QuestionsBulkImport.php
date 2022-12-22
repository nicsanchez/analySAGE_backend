<?php

namespace App\Imports;

use App\AO\BulkHistory\BulkHistoryAO;
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
    public static $semester = null;

    public function __construct($semester)
    {
        if (SemesterAO::findSemesterId($semester)) {
            self::$semester = SemesterAO::findSemesterId($semester)->id;
        }
    }

    public function collection($rows)
    {
        $cont = 0;
        $storeQuestionsRequests = new StoreQuestions();
        if (BulkHistoryAO::existInscribedHistory(self::$semester) && self::$semester) {
            $this->validateQuestionsExistBySemester();
            foreach ($rows as $row) {
                $cont += 1;
                if ($row->filter()->isNotEmpty() && $cont != 1) {
                    $data = [
                        'day_session' => $row[0],
                        'number' => $row[1],
                        'right_answer' => $row[2],
                    ];
                    $validator = Validator::make(
                        $data,
                        $storeQuestionsRequests->rules(),
                        $storeQuestionsRequests->messages());

                    if ($validator->fails()) {
                        self::$errors[] = ['row' => $cont, 'error' => $validator->errors()->all()];
                    } else {
                        $data['id_semester'] = self::$semester;
                        $data['created_at'] = date('Y-m-d H:i:s');
                        $data['updated_at'] = date('Y-m-d H:i:s');
                        QuestionsAO::storeQuestions($data);
                    }
                }
            }
            $this->storeLogFromQuestionsBulk();
        } else {
            self::$errors[] = [
                'row' => '-',
                'error' => ['No se ha realizado un cargue de inscritos al semestre ingresado.'],
            ];
        }
    }

    public function validateQuestionsExistBySemester()
    {
        if (QuestionsAO::semesterHaveQuestions(self::$semester)) {
            QuestionsAO::deleteQuestionsInSemester(self::$semester);
        }
    }

    public function storeLogFromQuestionsBulk()
    {
        if (QuestionsAO::semesterHaveMoreThanOneQuestion(self::$semester)) {
            $now = date('Y-m-d H:i:s');
            $data = [
                'questions' => 1,
                'updated_at' => $now,
            ];
            BulkHistoryAO::updateHistory(self::$semester, $data);
        }
    }
}
