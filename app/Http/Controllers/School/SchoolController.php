<?php

namespace App\Http\Controllers\School;

use App\BL\School\SchoolBL;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\School\BulkRequest;

class SchoolController extends Controller
{
    public function storeSchools(BulkRequest $request)
    {
        return SchoolBL::storeSchools($request);
    }

    public function getAllNaturalness()
    {
        return SchoolBL::getAllNaturalness();
    }

    public function getAllSchoolsByNaturalnessAndMunicipality(Request $request)
    {
        return SchoolBL::getAllSchoolsByNaturalnessAndMunicipality($request->naturalness, $request->idMunicipality);
    }
}
