<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\BlogController;

Route::middleware('auth:sanctum')->group(function () { // Kullanıcı girişi varsa işlem yapsın
    Route::resource('blog', BlogController::class)->name('n_blog');
    Route::post('/postblogfilter', [UsersController::class, 'postBlogFilter']);
});

Route::post('/register', [UsersController::class, 'register']);
Route::post('/login', [UsersController::class, 'login']);