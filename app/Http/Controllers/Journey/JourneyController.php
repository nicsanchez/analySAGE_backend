<?php

namespace App\Http\Controllers\Journey;

use App\BL\Journey\JourneyBL;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JourneyController extends Controller
{
    public function getAllJourneys(Request $request)
    {
        return JourneyBL::getAllJourneys($request->idSemester);
    }
}
