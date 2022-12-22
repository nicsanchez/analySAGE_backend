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

class AnswersBulkImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public static $errors = [];
    public static $semester = null;
    public static $firstTime = false;
    public static $rightQuestionsBySemester = null;

    public function __construct($semester)
    {
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
                            $this->getRightQuestions(self::$firstTime, self::$semester);
                            $presentation = PresentationAO::findByCredentialSemester(
                                self::$semester,
                                $data['credential']
                            );
                            $this->deleteAnswerIfExists(self::$semester, $data);
                            $rightQuestions = $this->getRightQuestionBySession($presentation);
                            $arrayOfAnswers = $this->getArrayOfAnswers($data['marked_answers']);
                            $this->storeAnswers($rightQuestions, $arrayOfAnswers, $presentation);
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

    public function storeAnswers($rightQuestions, $arrayOfAnswers, $presentation)
    {
        foreach ($rightQuestions as $rightQuestion) {
            $i = $rightQuestion->number - 1;
            $dataAnswers = [
                'id_presentation' => $presentation->id,
                'id_question' => $rightQuestion->id,
                'selected_answer' => $arrayOfAnswers[$i],
            ];
            if ($arrayOfAnswers[$i] !== $rightQuestion->right_answer || $arrayOfAnswers[$i] === ' ') {
                $dataAnswers['right_answer'] = false;
            } else {
                $dataAnswers['right_answer'] = true;
            }
            $dataAnswers['created_at'] = date('Y-m-d H:i:s');
            $dataAnswers['updated_at'] = date('Y-m-d H:i:s');
            AnswersAO::storeAnswers($dataAnswers);
        }
    }

    public function getRightQuestionBySession($presentation)
    {
        $daySession = $presentation->day_session;
        return self::$rightQuestionsBySemester->filter(function ($item) use ($daySession) {
            return $item->day_session == $daySession;
        });
    }

    public function getRightQuestions($firstTime, $semesterId)
    {
        if (!self::$firstTime) {
            self::$firstTime = true;
            self::$rightQuestionsBySemester = QuestionsAO::getRightQuestions($semesterId);
        }
    }

    public function deleteAnswerIfExists($semesterId, $data)
    {
        if (AnswersAO::issetCredentialInSemester($semesterId, $data['credential'])) {
            AnswersAO::deleteAnswer($semesterId, $data['credential']);
        }
    }

    public function getArrayOfAnswers($stringOfAnswers)
    {
        return str_split($stringOfAnswers);
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
