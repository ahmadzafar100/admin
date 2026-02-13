<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    function index()
    {
        $user = DB::table('users')->where('id', session('user')->id)->first();
        return view('profile', ['data' => $user]);
    }

    function update(Request $r)
    {
        $update = DB::table('users')->where('id', session('user')->id)->update([
            'name' => $r->name,
            'email' => $r->email,
            'mobile' => $r->mobile
        ]);

        if ($update) {
            return redirect('/admin/profile');
        }
    }
}
