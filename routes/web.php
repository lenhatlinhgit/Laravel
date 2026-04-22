<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/
Route::get('/', [PostController::class, 'index']);

/*
|--------------------------------------------------------------------------
| STATIC PAGES
|--------------------------------------------------------------------------
*/
Route::view('/aboutme', 'aboutme');
Route::view('/contact', 'contact');

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
| USER + ADMIN HOME
|--------------------------------------------------------------------------
*/
Route::get('/home', [PostController::class, 'index'])
    ->middleware('checkrole:user,admin');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

// Dashboard
Route::get('/admin', [PostController::class, 'admin'])
    ->middleware('checkrole:admin');

// Trang tạo bài viết
Route::get('/createpost', function () {
    return view('createpost');
})->middleware('checkrole:admin');

/*
|--------------------------------------------------------------------------
| UPLOAD
|--------------------------------------------------------------------------
*/
/*
|--------------------------------------------------------------------------
| POST DETAIL
|--------------------------------------------------------------------------
*/
Route::get('/post/{id}', [PostController::class, 'show']);
Route::get('/location/{location}', [PostController::class, 'byLocation']);

Route::get('/createpost', [PostController::class, 'createPost'])
    ->middleware('checkrole:admin');

Route::post('/upload', [PostController::class, 'upload'])
    ->middleware('checkrole:admin');