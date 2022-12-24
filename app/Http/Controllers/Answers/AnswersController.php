<?php

namespace App\Http\Controllers\Answers;

use App\BL\Answers\AnswersBL;
use App\Http\Controllers\Controller;
use App\Http\Requests\Answers\ValidateBulkAnswers;
use Illuminate\Http\Request;

class AnswersController extends Controller
{
    public function storeAnswers(ValidateBulkAnswers $request)
    {
        return AnswersBL::storeAnswers($request);
    }

    public function getRightAndBadAnswersQuantity(Request $request)
    {
        return AnswersBL::getRightAndBadAnswersQuantity($request);
    }
}
