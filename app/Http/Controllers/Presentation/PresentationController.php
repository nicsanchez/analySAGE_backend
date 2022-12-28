<?php

namespace App\Http\Controllers\Presentation;

use App\BL\Presentation\PresentationBL;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PresentationController extends Controller
{
    public function getAdmittedOrUnAdmittedPeople(Request $request)
    {
        return PresentationBL::getAdmittedOrUnAdmittedPeople($request);
    }
}
