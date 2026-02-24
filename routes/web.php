<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NewsImageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubcategoryController;
use Illuminate\Support\Facades\Route;

/* Route::get('/', function () {
    return view('login');
}); */

Route::get('/admin/login', [AuthController::class, 'index'])->name('login');
Route::post('/admin/login', [AuthController::class, 'login']);
Route::get('/admin/logout', [AuthController::class, 'logout']);
Route::get('/captcha-image', [AuthController::class, 'generateCaptcha']);

Route::view('/blank', 'blank');

Route::middleware(['auth', 'nocache', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index']);
    Route::get('/admin/profile', [ProfileController::class, 'index']);
    Route::post('/admin/profile-update', [ProfileController::class, 'update']);
    Route::get('/admin/change-password', [ProfileController::class, 'change_password']);
    Route::post('/admin/update-pass', [ProfileController::class, 'update_password']);
    Route::resource('/admin/category', CategoryController::class);
    Route::post('/admin/category-import', [CategoryController::class, 'import']);
    Route::get('/admin/deactivate-category/{id}', [CategoryController::class, 'deactivate']);
    Route::get('/admin/activate-category/{id}', [CategoryController::class, 'activate']);
    Route::resource('/admin/subcategory', SubcategoryController::class);
    Route::post('/admin/subcategory-import', [SubcategoryController::class, 'import']);
    Route::get('/admin/deactivate-subcategory/{id}', [SubcategoryController::class, 'deactivate']);
    Route::get('/admin/activate-subcategory/{id}', [SubcategoryController::class, 'activate']);
    Route::resource('/admin/news', NewsController::class);
    Route::get('/get-subcategories/{category}', [NewsController::class, 'getSubcategories']);
    Route::get('/admin/news-images/{id}', [NewsImageController::class, 'index']);
    Route::post('/admin/add-image/{id}', [NewsImageController::class, 'addImage']);
    Route::delete('/admin/delete-news-image/{id}', [NewsImageController::class, 'deleteImage']);
    Route::post('/news/update-status', [NewsController::class, 'updateStatus'])
        ->name('news.updateStatus');
    Route::get('/admin/news-export', [NewsController::class, 'export']);
});
