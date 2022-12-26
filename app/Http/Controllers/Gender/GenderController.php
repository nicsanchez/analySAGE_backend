<?php

namespace App\Http\Controllers\Gender;

use App\BL\Gender\GenderBL;
use App\Http\Controllers\Controller;

class GenderController extends Controller
{
    public function getAllGenders()
    {
        return GenderBL::getAllGenders();
    }
}
