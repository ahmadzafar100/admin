<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

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
            Session::flash('success_msg', 'Profile updated.');
            return redirect('/admin/profile');
        }
    }

    function change_password()
    {
        return view('change-password');
    }

    function update_password(Request $r)
    {
        $r->validate(
            [
                'current_pass' => 'required',
                'new_pass' => 'required',
                'confirm_pass' => 'required',
            ],
            [
                'current_pass.required' => 'Current password is required.',
                'new_pass.required' => 'New password is required.',
                'confirm_pass.required' => 'Password confirmation is required.',
            ]
        );
        if (!Hash::check($r->current_pass, session('user')->password)) {
            Session::flash('err_msg', 'Your current password is incorrect.');
            return redirect('/admin/change-password');
        }
        if ($r->new_pass !== $r->confirm_pass) {
            Session::flash('err_msg', 'Password confirmation failed.');
            return redirect('/admin/change-password');
        }
        $newPassword = Hash::make($r->new_pass);

        $update = DB::table('users')->where('id', session('user')->id)->update([
            'password' => $newPassword,
        ]);

        if ($update) {
            Session::flush();
            Session::flash('success_msg', 'Password changed successfully. Please login again.');
            return redirect('/admin/login');
        }
    }
}
