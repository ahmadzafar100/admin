<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    function index()
    {
        $user = Auth::user();
        return view('admin.profile', ['data' => $user]);
    }

    function update(Request $r)
    {
        $user = Auth::user();

        $user->name = $r->name;
        $user->email = $r->email;
        $update = $user->save();

        if (!$update) {
            Alert::toast('Profile not saved.', 'error');
            return redirect('/admin/profile');
        }

        Alert::toast('Profile saved.', 'success');
        return redirect('/admin/profile');
    }

    function change_password()
    {
        return view('admin.change-password');
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

        $user = Auth::user();

        $user->password = $r->newPassword;
        $update = $user->save();

        if (!$update) {
            Alert::toast('Password not changed.', 'error');
            return redirect('/admin/login');
        }

        Session::flush();
        Alert::toast('Password changed successfully. Please login again.', 'success');
        return redirect('/admin/login');
    }
}
