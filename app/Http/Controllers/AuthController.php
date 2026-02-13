<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    function login()
    {
        return view('login');
    }

    function validate(Request $r)
    {
        $r->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $row = DB::table('users')->where('username', $r->username)->first();
        if (!$row || !Hash::check($r->password, $row->password)) {
            Session::flash('err_msg', 'Wrong credentials...');
            return redirect('/admin/login');
        }
        Session::put('user', $row);
        return redirect('/admin/dashboard');
    }

    function logout()
    {
        Session::flush();
        return redirect('/admin/login');
    }
}
