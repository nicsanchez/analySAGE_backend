<?php

namespace App\Http\Controllers\Semester;

use App\BL\Semester\SemesterBL;
use App\Http\Controllers\Controller;

class SemesterController extends Controller
{
    public function getAllSemesters()
    {
        return SemesterBL::getAllSemesters();
    }
}
