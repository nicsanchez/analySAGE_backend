<?php

namespace App\Http\Controllers\State;

use App\BL\State\StateBL;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function getAllStatesByCountry(Request $request)
    {
        return StateBL::getAllStatesByCountry($request->idCountry);
    }
}
