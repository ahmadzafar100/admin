<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\NewsImageController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SubcategoryController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function(){
    Route::get('/admin/login', 'index')->name('login');
    Route::post('/admin/login', 'login');
    Route::get('/admin/logout', 'logout');
    Route::get('/captcha-image', 'generateCaptcha');
});

Route::middleware(['auth', 'nocache'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index']);

    Route::controller(ProfileController::class)->group(function(){
        Route::get('/admin/profile', 'index');
        Route::post('/admin/profile-update', 'update');
        Route::get('/admin/change-password', 'change_password');
        Route::post('/admin/update-pass', 'update_password');
    });
    
    Route::resource('/admin/category', CategoryController::class);

    Route::controller(CategoryController::class)->group(function(){
        Route::post('/admin/category-import', 'import');
        Route::get('/admin/deactivate-category/{id}', 'deactivate');
        Route::get('/admin/activate-category/{id}', 'activate');
        Route::post('admin/category/status/{id}', 'changeStatus');
    });

    Route::resource('/admin/subcategory', SubcategoryController::class);

    Route::controller(SubcategoryController::class)->group(function(){
        Route::post('/admin/subcategory-import', 'import');
        Route::get('/admin/deactivate-subcategory/{id}', 'deactivate');
        Route::get('/admin/activate-subcategory/{id}', 'activate');
        Route::post('admin/subcategory/status/{id}', 'changeStatus');
    });

    Route::resource('/admin/news', NewsController::class);

    Route::controller(NewsController::class)->group(function(){
        Route::post('/admin/news-import', 'import');
        Route::get('/get-subcategories/{category}',  'getSubcategories');
        Route::post('/news/update-status', 'updateStatus')->name('news.updateStatus');
        Route::get('/admin/news-export', 'export');
    });

    Route::controller(NewsImageController::class)->group(function(){
        Route::get('/admin/news-images/{id}', 'index');
        Route::post('/admin/add-image/{id}', 'addImage');
        Route::delete('/admin/delete-news-image/{id}', 'deleteImage');
    });

    Route::controller(PermissionController::class)->group(function(){
        Route::get('/admin/permissions', 'index');
        Route::post('/admin/give-permit', 'givePermit');
        Route::get('/get-role-permissions/{role}', 'getPermissions');
        Route::post('/admin/add-permission', 'addPermission');
    });
});
