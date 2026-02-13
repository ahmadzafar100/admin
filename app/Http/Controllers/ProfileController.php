<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    function index()
    {
        return view('profile');
    }

    function update(Request $r)
    {
        $update = DB::table('users')->insert([
            'name' => $r->name,
            'email' => $r->email,
            'mobile' => $r->mobile
        ]);
    }
}
