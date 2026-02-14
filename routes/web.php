<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/* Route::get('/', function () {
    return view('login');
}); */

Route::get('/admin/login', [AuthController::class, 'login']);
Route::post('/admin/login', [AuthController::class, 'validate']);
Route::get('/admin/logout', [AuthController::class, 'logout']);

Route::view('/blank', 'blank');

Route::middleware(['isvalid', 'nocache'])->group(function () {
    Route::view('/admin/dashboard', 'dashboard');
    Route::get('/admin/profile', [ProfileController::class, 'index']);
    Route::post('/admin/profile-update', [ProfileController::class, 'update']);
    Route::get('/admin/change-password', [ProfileController::class, 'change_password']);
    Route::post('/admin/update-pass', [ProfileController::class, 'update_password']);
    Route::resource('/admin/category', CategoryController::class);
    Route::post('/admin/category-import', [CategoryController::class, 'import']);
    Route::get('/admin/deactivate-category/{id}', [CategoryController::class, 'deactivate']);
    Route::get('/admin/activate-category/{id}', [CategoryController::class, 'activate']);
});
