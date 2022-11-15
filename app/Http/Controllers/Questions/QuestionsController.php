<?php

namespace App\Http\Controllers\Questions;

use App\BL\Questions\QuestionsBL;
use App\Http\Controllers\Controller;
use App\Http\Requests\Questions\ValidateBulkQuestions;

class QuestionsController extends Controller
{
    public function storeQuestions(ValidateBulkQuestions $request)
    {
        return QuestionsBL::storeQuestions($request->file);
    }
}
