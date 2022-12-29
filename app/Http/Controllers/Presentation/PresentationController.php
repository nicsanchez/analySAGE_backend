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

    public function getDetailsAdmittedOrUnAdmittedPeopleByVersion(Request $request)
    {
        return PresentationBL::getDetailsAdmittedOrUnAdmittedPeople($request, 'p.version');
    }

    public function getDetailsAdmittedOrUnAdmittedPeopleByState(Request $request)
    {
        return PresentationBL::getDetailsAdmittedOrUnAdmittedPeople($request, 'sta.name');
    }

    public function getDetailsAdmittedOrUnAdmittedPeopleByStratum(Request $request)
    {
        return PresentationBL::getDetailsAdmittedOrUnAdmittedPeople($request, 'st.number');
    }

    public function getDetailsAdmittedOrUnAdmittedPeopleByProgram(Request $request)
    {
        if ($request['type'] == 1) {
            $data = PresentationBL::getDetailsAdmittedOrUnAdmittedPeople($request, 'pra.name');
        } else {
            $data = PresentationBL::getDetailsAdmittedOrUnAdmittedPeople($request, 'prf.name');
        }

        return $data;
    }

    public function getDetailsAdmittedOrUnAdmittedPeopleByRegistrationType(Request $request)
    {
        return PresentationBL::getDetailsAdmittedOrUnAdmittedPeople($request, 'rt.name');
    }
}
