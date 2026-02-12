<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::view('/profile', 'profile');
Route::view('/blank', 'blank');
Route::view('/dashboard', 'dashboard');
