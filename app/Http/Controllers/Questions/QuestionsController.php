<?php

namespace App\Http\Controllers\Questions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BL\Questions\QuestionsBL;
use App\Http\Requests\Questions\ValidateBulkQuestions;

class QuestionsController extends Controller
{
    public function storeQuestions(ValidateBulkQuestions $request){
        return QuestionsBL::storeQuestions($request->file);
    }
}
