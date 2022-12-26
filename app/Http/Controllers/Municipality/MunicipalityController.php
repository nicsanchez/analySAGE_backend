<?php

namespace App\Http\Controllers\Municipality;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BL\Municipality\MunicipalityBL;
use App\Http\Requests\Municipality\BulkRequest;

class MunicipalityController extends Controller
{
    public function storeMunicipalities(BulkRequest $request)
    {
        return MunicipalityBL::storeMunicipalities($request);
    }

    public function getAllMunicipalitiesByState(Request $request)
    {
        return MunicipalityBL::getAllMunicipalitiesByState($request->idState);
    }
}
