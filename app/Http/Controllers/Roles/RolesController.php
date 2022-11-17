<?php

namespace App\Http\Controllers\Roles;

use App\BL\Roles\RolesBL;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    public function getAllRoles(Request $request)
    {
        return RolesBL::getAllRoles();
    }

    public function getPermissions(Request $request)
    {
        return RolesBL::getPermissions();
    }
}
