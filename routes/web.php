<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});

Route::view('/profile', 'profile');
Route::view('/blank', 'blank');
