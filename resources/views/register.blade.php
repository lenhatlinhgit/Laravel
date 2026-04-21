<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký</title>

    <style>
        body {
            margin: 0;
            font-family: 'DM Sans', sans-serif;
            background: #f1f1f1;
        }

        .container {
            max-width: 1168px;
            margin: 0 auto;
            padding: 40px 16px;
        }

        .login-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 85vh;
            flex-direction: column;
            gap: 8px;
        }

        .login-logo {
            margin-bottom: 60px;
        }

        .login-logo img {
            width: 250px;
        }

        .Contact-item {
            width: 100%;
            max-width: 460px;
            background: #fff;
            border: 1px solid rgba(0,0,0,0.05);
            padding: 44px 42px;
            box-sizing: border-box;
        }

        .title {
            font-size: 24px;
            font-family: Marcellus, serif;
            text-align: center;
            margin-bottom: 26px;
            color: #1f1717;
        }

        .information {
            font-weight: 600;
            font-size: 14px;
            margin: 14px 0 8px;
            color: #1f1717;
        }

        .input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid rgba(0,0,0,0.05);
            outline: none;
            font-size: 14px;
            box-sizing: border-box;
            background: #f8f5ef;
        }

        .input:focus {
            border-color: #1f1717;
            background: #fffdf8;
        }

        .btn {
            width: 100%;
            margin-top: 22px;
            padding: 12px 14px;
            background: #1f1717;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 14px;
            box-sizing: border-box;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .link {
            text-align: center;
            margin-top: 16px;
            font-size: 14px;
        }

        .link a {
            color: #4f4d49;
            text-decoration: none;
        }

        .link a:hover {
            text-decoration: underline;
        }

        .alert {
            padding: 10px;
            margin-bottom: 12px;
            font-size: 14px;
            text-align: center;
        }

        .success {
            background: #e6f7e6;
            color: #2b7a2b;
        }

        .error {
            background: #ffe6e6;
            color: #a12b2b;
        }

        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 1000px #faf9f6 inset !important;
            -webkit-text-fill-color: #1f1717 !important;
            transition: background-color 9999s ease-in-out 0s;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="login-wrapper">

        <!-- LOGO -->
        <div class="login-logo">
            <img src="http://127.0.0.1:8000/img/logo-300x51.webp" alt="logo">
        </div>

        <!-- FORM -->
        <div class="Contact-item">

            <div class="title">Đăng ký</div>

            {{-- ALERT --}}
            @if(session('success'))
                <div class="alert success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert error">{{ session('error') }}</div>
            @endif

            <form method="POST" action="/register">
                @csrf

                <div class="information">Họ tên</div>
                <input type="text" name="name" class="input" required>

                <div class="information">Tên đăng nhập</div>
                <input type="text" name="username" class="input" required>

                <div class="information">Email</div>
                <input type="email" name="email" class="input" required>

                <div class="information">Mật khẩu</div>
                <input type="password" name="password" class="input" required>

                <div class="information">Xác nhận mật khẩu</div>
                <input type="password" name="password_confirmation" class="input" required>

                <button class="btn">Đăng ký</button>
            </form>

            <div class="link">
                <a href="/login">Đã có tài khoản? Đăng nhập</a>
            </div>

        </div>

    </div>

</div>

</body>
</html>