<?php

namespace App\Http\Controllers\Municipality;

use App\BL\Municipality\MunicipalityBL;
use App\Http\Controllers\Controller;
use App\Http\Requests\Municipality\BulkRequest;

class MunicipalityController extends Controller
{
    public function storeMunicipalities(BulkRequest $request)
    {
        return MunicipalityBL::storeMunicipalities($request);
    }
}
