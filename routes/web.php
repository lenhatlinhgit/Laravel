<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Trang chính (HOME FEED)
|--------------------------------------------------------------------------
*/
Route::get('/', [PostController::class, 'index']);

/*
|--------------------------------------------------------------------------
| TEST
|--------------------------------------------------------------------------
*/
Route::get('/linh', function () {
    return view('linh');
});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/logout', [AuthController::class, 'logout']);

/*
|--------------------------------------------------------------------------
| HOME (user + admin) - FIXED
| 👉 QUAN TRỌNG: phải truyền $posts vào view
|--------------------------------------------------------------------------
*/
Route::get('/home', [PostController::class, 'index'])
    ->middleware('checkrole:user,admin');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::get('/admin', function () {
    return view('admin');
})->middleware('checkrole:admin');

/*
|--------------------------------------------------------------------------
| UPLOAD (admin only)
|--------------------------------------------------------------------------
*/
Route::post('/upload', [PostController::class, 'upload'])
    ->middleware('checkrole:admin');

Route::get('/post/{id}', [PostController::class, 'show']);