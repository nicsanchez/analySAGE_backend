<?php

namespace App\Imports;

use App\AO\Answers\AnswersAO;
use App\AO\BulkHistory\BulkHistoryAO;
use App\AO\Presentation\PresentationAO;
use App\AO\Questions\QuestionsAO;
use App\AO\Semester\SemesterAO;
use App\Http\Requests\Answers\StoreAnswers;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Log;

class AnswersBulkImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public static $errors = [];
    public static $semester = null;

    public function __construct($semester)
    {
        $this->now = date('Y-m-d H:i:s');
        if (SemesterAO::findSemesterId($semester)) {
            self::$semester = SemesterAO::findSemesterId($semester)->id;
        }
    }

    public function collection($rows)
    {
        $cont = 0;
        $storeAnswersRequests = new StoreAnswers();
        if (BulkHistoryAO::existInscribedHistory(self::$semester) && self::$semester) {
            if (BulkHistoryAO::existQuestionHistory(self::$semester)) {
                foreach ($rows as $row) {
                    $cont += 1;
                    if ($row->filter()->isNotEmpty() && $cont != 1) {
                        $data = [
                            'credential' => $row[0],
                            'marked_answers' => $row[1],
                        ];
                        $validator = Validator::make(
                            $data,
                            $storeAnswersRequests->rules(),
                            $storeAnswersRequests->messages());
                        if ($validator->fails()) {
                            self::$errors[] = ['row' => $cont, 'error' => $validator->errors()->all()];
                        } else {
                            $presentationId = PresentationAO::findByCredentialSemester(
                                self::$semester,
                                $data['credential']
                            );
                            $this->updateOrStoreAnswersIfExists($presentationId, $data['marked_answers']);
                            Log::error($cont);
                        }
                    }
                }
                $this->storeLogFromAnswersBulk();
            } else {
                self::$errors[] = [
                    'row' => '-',
                    'error' => ['No se ha realizado un cargue de ruta de respuestas previamente.'],
                ];
            }
        } else {
            self::$errors[] = [
                'row' => '-',
                'error' => ['No se ha realizado un cargue de inscritos previamente.'],
            ];
        }
    }

    public function updateOrStoreAnswersIfExists($presentationId, $answers)
    {
        $idAnswers = AnswersAO::credentialHaveAnswersInSemester($presentationId->id);
        $data = [
            'id_presentation' => $presentationId->id,
            'answers_marked' => $answers,
            'created_at' => $this->now,
            'updated_at' => $this->now
        ];
        if ($idAnswers) {
            unset($data['updated_at']);
            AnswersAO::updateAnswers($data, $idAnswers);
        } else {
            AnswersAO::storeAnswers($data);
        }
    }


    public function storeLogFromAnswersBulk()
    {
        $now = date('Y-m-d H:i:s');
        $data = [
            'answers' => 1,
            'updated_at' => $now,
        ];
        BulkHistoryAO::updateHistory(self::$semester, $data);
    }
}
