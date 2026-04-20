<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/linh', function () {
    return view('linh');
});
use App\Http\Controllers\AuthController;

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/logout', [AuthController::class, 'logout']);

Route::get('/home', function () {
    if (!session('user')) {
        return redirect('/login');
    }
    return view('home');
});

Route::get('/admin', function () {

    if (!session('user') || session('role') !== 'admin') {
        return redirect('/login');
    }

    return view('admin');
});