<?php

namespace App\Http\Controllers\Continent;

use App\BL\Continent\ContinentBL;
use App\Http\Controllers\Controller;

class ContinentController extends Controller
{
    public function getAllContinents()
    {
        return ContinentBL::getAllContinents();
    }
}
