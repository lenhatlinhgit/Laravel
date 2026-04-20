<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký</title>
</head>
<body>

<h2>Đăng ký</h2>

<form method="POST" action="/register">
    <!-- nếu dùng Laravel thì thêm CSRF -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <div>
        <label>Họ tên</label>
        <input type="text" name="name" required>
    </div>

    <div>
        <label>Tên đăng nhập</label>
        <input type="text" name="username" required>
    </div>

    <div>
        <label>Email</label>
        <input type="email" name="email" required>
    </div>

    <div>
        <label>Mật khẩu</label>
        <input type="password" name="password" required>
    </div>

    <div>
        <label>Xác nhận mật khẩu</label>
        <input type="password" name="password_confirmation" required>
    </div>

    <button type="submit">Đăng ký</button>
</form>

<p><a href="/login">Đã có tài khoản? Đăng nhập</a></p>

</body>
</html>