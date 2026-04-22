<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister() {
        return view('register');
    }

    public function register(Request $request)
{
    $request->validate([
        'name' => 'required',
        'username' => 'required|min:3|unique:users,username',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed'
    ]);

    DB::table('users')->insert([
        'name' => $request->name,
        'username' => $request->username,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'user', // mặc định
        'created_at' => now(),
        'updated_at' => now()
    ]);

    return redirect('/login')->with('success', 'Đăng ký thành công!');
}

    public function showLogin() {
        return view('login');
    }

    public function login(Request $request)
{
    $user = DB::table('users')
        ->where('username', $request->username)
        ->first();

    if ($user && Hash::check($request->password, $user->password)) {

        // lưu session
        session([
            'user' => $user->username,
            'role' => $user->role
        ]);

        // 🔥 phân quyền tại đây
        if ($user->role === 'admin') {
            return redirect('/admin');
        } else {
            return redirect('/home');
        }
    }

    return back()->with('error', 'Sai tài khoản hoặc mật khẩu');
}

    public function home()
    {
        if (!session('user')) {
            return redirect('/login');
        }

        return view('home');
    }

    public function logout()
{
    session()->flush();
    return redirect('/login');
}
public function showChangePassword()
{
    return view('changepassword');
}

public function changePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|min:6|confirmed',
    ]);

    // lấy user từ session (vì bạn không dùng Auth)
    $username = session('user');

    if (!$username) {
        return redirect('/login');
    }

    $user = DB::table('users')
        ->where('username', $username)
        ->first();

    // check mật khẩu cũ
    if (!$user || !Hash::check($request->current_password, $user->password)) {
        return back()->withErrors([
            'current_password' => 'Mật khẩu hiện tại không đúng'
        ]);
    }

    // update mật khẩu mới
    DB::table('users')
        ->where('username', $username)
        ->update([
            'password' => Hash::make($request->new_password),
            'updated_at' => now()
        ]);

    return back()->with('success', 'Đổi mật khẩu thành công');
}
}
