<?php

namespace App\Http\Controllers\Faculty;

use App\BL\Faculty\FacultyBL;
use App\Http\Controllers\Controller;

class FacultyController extends Controller
{
    public function getAllFaculties()
    {
        return FacultyBL::getAllFaculties();
    }
}
