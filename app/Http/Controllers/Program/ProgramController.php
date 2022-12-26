<?php

namespace App\Http\Controllers\Program;

use Illuminate\Http\Request;
use App\BL\Program\ProgramBL;
use App\Http\Controllers\Controller;
use App\Http\Requests\Program\BulkRequest;

class ProgramController extends Controller
{
    public function storePrograms(BulkRequest $request)
    {
        return ProgramBL::storePrograms($request);
    }

    public function getProgramsByFaculty(Request $request)
    {
        return ProgramBL::getProgramsByFaculty($request->idFaculty);
    }
}
