<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>

<div class="container">

    <div class="login-wrapper">

        <!-- LOGO -->
        <div class="login-logo">
            <img src="http://127.0.0.1:8000/img/logo-300x51.webp">
        </div>

        <!-- FORM -->
        <div class="Contact-item">

            <div class="title">Đăng nhập</div>

            {{-- ALERT --}}
            @if(session('success'))
                <div class="alert success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert error">{{ session('error') }}</div>
            @endif

            <form method="POST" action="/login">
                @csrf

                <div class="information">Tên đăng nhập</div>
                <input type="text" name="username" class="input" required>

                <div class="information">Mật khẩu</div>
                <input type="password" name="password" class="input" required>

                <button class="btn">Đăng nhập</button>
            </form>

            <div class="link">
                <a href="/register">Chưa có tài khoản? Đăng ký</a>
            </div>

        </div>

    </div>

</div>

</body>
</html>