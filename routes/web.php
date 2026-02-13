<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/* Route::get('/', function () {
    return view('login');
}); */

Route::get('/admin/login', [AuthController::class, 'login']);
Route::post('/admin/login', [AuthController::class, 'validate']);

Route::view('/admin/profile', 'profile');
Route::view('/blank', 'blank');
Route::view('/admin/dashboard', 'dashboard');
