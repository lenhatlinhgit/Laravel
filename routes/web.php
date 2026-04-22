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
| USER HOME
|--------------------------------------------------------------------------
*/
Route::get('/home', [PostController::class, 'index'])
    ->middleware('checkrole:user,admin');

/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/

// Dashboard
Route::get('/admin', [PostController::class, 'admin'])
    ->middleware('checkrole:admin');

// Create post page
Route::get('/createpost', [PostController::class, 'createPost'])
    ->middleware('checkrole:admin');

// Upload post
Route::post('/upload', [PostController::class, 'upload'])
    ->middleware('checkrole:admin');

// Change password page
Route::get('/changepassword', [AuthController::class, 'showChangePassword'])
    ->middleware('checkrole:admin');

Route::post('/changepassword', [AuthController::class, 'changePassword'])
    ->middleware('checkrole:admin');

/*
|--------------------------------------------------------------------------
| POST DETAIL
|--------------------------------------------------------------------------
*/
Route::get('/post/{id}', [PostController::class, 'show']);
Route::get('/location/{location}', [PostController::class, 'byLocation']);

Route::get('/post/{id}/edit', [PostController::class, 'edit']);
Route::post('/post/{id}/update', [PostController::class, 'update']);

Route::delete('/post/{id}/delete', [PostController::class, 'destroy']);