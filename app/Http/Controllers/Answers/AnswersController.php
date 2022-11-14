<?php

namespace App\Http\Controllers\Answers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BL\Answers\AnswersBL;
use App\Http\Requests\Answers\ValidateBulkAnswers;

class AnswersController extends Controller
{
    public function storeAnswers(ValidateBulkAnswers $request){
        return AnswersBL::storeAnswers($request->file);
    }
}
