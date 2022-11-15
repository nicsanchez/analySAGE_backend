<?php

namespace App\Http\Controllers\Logs;

use App\BL\Logs\LogsBL;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    public function getLogs(Request $request)
    {
        return LogsBL::getLogs($request->input());
    }
}
