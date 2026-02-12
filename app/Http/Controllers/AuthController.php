<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    function login()
    {
        return view('login');
    }

    function validate(Request $r) {
        $r->validate([
            'username'=>'required',
            'password'=>'required'
        ]);

        
    }
}
