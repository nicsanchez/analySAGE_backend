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

    public function getDetailsAnswerByVersion(Request $request)
    {
        return AnswersBL::getDetailsAnswers($request, 'p.version');
    }

    public function getDetailsAnswerByState(Request $request)
    {
        return AnswersBL::getDetailsAnswers($request, 'sta.name');
    }

    public function getDetailsAnswerByStratum(Request $request)
    {
        return AnswersBL::getDetailsAnswers($request, 'st.number');
    }

    public function getDetailsAnswerByFacultyFirstOption(Request $request)
    {
        return AnswersBL::getDetailsAnswers($request, 'ff.name');
    }

    public function getDetailsAnswerByRegistrationType(Request $request)
    {
        return AnswersBL::getDetailsAnswers($request, 'rt.name');
    }

    public function getDetailsAnswerBySchool(Request $request)
    {
        return AnswersBL::getDetailsAnswers($request, 'sc.name');
    }
}
