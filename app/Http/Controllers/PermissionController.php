<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    function index()
    {
        $users = User::with('roles', 'permissions')->get();
        return view('permissions', compact('users'));
    }
}
