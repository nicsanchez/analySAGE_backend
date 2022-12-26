<?php

namespace App\Http\Controllers\Stratum;

use App\BL\Stratum\StratumBL;
use App\Http\Controllers\Controller;

class StratumController extends Controller
{
    public function getAllStratums()
    {
        return StratumBL::getAllStratums();
    }
}
