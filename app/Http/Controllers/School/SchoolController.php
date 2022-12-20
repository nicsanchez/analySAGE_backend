<?php

namespace App\Http\Controllers\School;

use App\BL\School\SchoolBL;
use App\Http\Controllers\Controller;
use App\Http\Requests\School\BulkRequest;

class SchoolController extends Controller
{
    public function storeSchools(BulkRequest $request)
    {
        return SchoolBL::storeSchools($request);
    }
}
