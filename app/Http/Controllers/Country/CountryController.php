<?php

namespace App\Http\Controllers\Country;

use App\BL\Country\CountryBL;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function getAllCountriesByContinent(Request $request)
    {
        return CountryBL::getAllCountriesByContinent($request->idContinent);
    }
}
