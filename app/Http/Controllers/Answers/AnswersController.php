<?php

namespace App\Http\Controllers\Answers;

use App\BL\Answers\AnswersBL;
use App\Http\Controllers\Controller;
use App\Http\Requests\Answers\ValidateBulkAnswers;

class AnswersController extends Controller
{
    public function storeAnswers(ValidateBulkAnswers $request)
    {
        return AnswersBL::storeAnswers($request->file);
    }
}
