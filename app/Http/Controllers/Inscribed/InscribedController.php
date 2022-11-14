<?php

namespace App\Http\Controllers\Inscribed;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BL\Inscribed\InscribedBL;
use App\Http\Requests\Inscribed\ValidateBulkFile;

class InscribedController extends Controller
{
    public function storeInscribedBySemester(ValidateBulkFile $request){
        return InscribedBL::storeInscribedBySemester($request->file);
    }
}
