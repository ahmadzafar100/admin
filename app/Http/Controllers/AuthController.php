<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

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
            'password' => 'required',
            'captcha' => 'required'
        ]);

        if ($r->captcha != session('captcha_text')) {
            return back()->withErrors(['captcha' => 'Invalid Captcha']);
        }

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

    public function generateCaptcha()
    {
        // $text = Str::random(6);
        $text = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 6);
        session(['captcha_text' => $text]);

        $image = imagecreate(120, 40);
        $bg = imagecolorallocate($image, 255, 255, 255);
        $textColor = imagecolorallocate($image, 0, 0, 0);

        imagestring($image, 5, 30, 10, $text, $textColor);

        ob_start();
        imagepng($image);
        $imageData = ob_get_clean();
        imagedestroy($image);

        return response($imageData)->header('Content-Type', 'image/png');
    }
}
