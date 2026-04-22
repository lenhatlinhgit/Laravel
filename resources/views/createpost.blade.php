<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Create Post</title>

<style>
/* GIỮ NGUYÊN CSS */
body {
    margin: 0;
    font-family: 'DM Sans', sans-serif;
    background: #f1f1f1;
    overflow: hidden;
}

.layout { display: flex; min-height: 100vh; }

.sidebar {
    width: 240px;
    height: 100vh;
    background: #1f1717;
    color: #fff;
    padding: 20px;
    position: fixed;
    top: 0;
    left: 0;
}

.sidebar h2 { font-size: 18px; margin-bottom: 25px; }

.menu {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 0;
    color: #cfcfcf;
    text-decoration: none;
    font-size: 14px;
}

.menu:hover { color: #fff; }

.main {
    margin-left: 280px;
    padding: 25px;
    height: 100vh;
    display: flex;
    flex: 1;
    flex-direction: column;
    overflow: hidden;
}

.topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.topbar h1 {
    margin: 0;
    font-size: 22px;
    color: #1f1717;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* STATS */
.stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
    margin-bottom: 20px;
    flex-shrink: 0;
}

.card {
    background: #fff;
    padding: 18px;
    border: 1px solid rgba(0,0,0,0.05);
}

.card h3 {
    margin: 0;
    font-size: 13px;
    color: #777;
}

.card p {
    font-size: 20px;
    margin-top: 8px;
    color: #1f1717;
}

/* FORM (thay table) */
.form-box {
    background: #fff;
    border: 1px solid rgba(0,0,0,0.05);
    padding: 20px;

    flex: 1;
    overflow-y: auto;
}
.form-box input {
    width: calc(100% - 20px);
    padding: 10px;
    margin-bottom: 12px;
    border: 1px solid #ddd;
    background: #faf9f6;
}

.form-box label {
    font-size: 13px;
    display: block;
    margin-bottom: 5px;
}

.form-box button {
    padding: 10px 20px;
    background: #1f1717;
    color: #fff;
    border: none;
    cursor: pointer;
}

.form-box button:hover {
    opacity: 0.9;
}

/* ALERT */
.alert-error {
    background: red;
    color: white;
    padding: 10px;
    margin-bottom: 10px;
}

.alert-success {
    background: green;
    color: white;
    padding: 10px;
    margin-bottom: 10px;
}

.icon {
    font-size: 16px;
    position: relative;
    top: 1px;
}
.form-box input[type="file"] {
    width: 100%;
    padding: 8px;
    background: #faf9f6;
    border: 1px solid #ddd;

    display: flex;
    justify-content: space-between; /* 👈 đẩy 2 bên */
    align-items: center;
}

/* nút chọn file */
.form-box input[type="file"]::file-selector-button {
    background: #1f1717;
    color: #fff;
    border: none;
    padding: 8px 14px;
    cursor: pointer;

    margin-left: auto; /* 👈 đẩy nút sang phải */
}

/* hover */
.form-box input[type="file"]::file-selector-button:hover {
    opacity: 0.85;
}
</style>
</head>

<body>

<div class="layout">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>Admin</h2>

        <a class="menu" href="/admin"><span class="icon">📊</span> Dashboard</a>
        <a class="menu" href="/createpost"><span class="icon">📝</span> Create Post</a>
        <a class="menu" href="#"><span class="icon">🔑</span> Change Password</a>
        <a class="menu" href="/logout"><span class="icon">🚪</span> Logout</a>
    </div>

    <!-- MAIN -->
    <div class="main">

        <div class="topbar">
            <h1><span class="icon">📝</span> Create Post</h1>
        </div>

        <!-- STATS -->
        <div class="stats">

            <div class="card">
                <h3>Total Posts</h3>
                <p>{{ $totalPosts }}</p>
            </div>

            <div class="card">
                <h3>Today Posts</h3>
                <p>{{ $todayPosts }}</p>
            </div>

            <div class="card">
                <h3>Users</h3>
                <p>{{ $totalUsers }}</p>
            </div>

            <div class="card">
                <h3>Views</h3>
                <p>{{ number_format($totalViews) }}</p>
            </div>

        </div>

        <!-- FORM -->
        <div class="form-box">

            {{-- lỗi --}}
            @if ($errors->any())
                <div class="alert-error">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            {{-- success --}}
            @if(session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="/upload" method="POST" enctype="multipart/form-data">
                @csrf

                <input type="text" name="title" placeholder="Title" value="{{ old('title') }}">

                <input type="text" name="location" placeholder="Location" value="{{ old('location') }}">

                <input type="text" name="author" placeholder="Author" value="{{ old('author') }}">

                <label>ZIP file:</label>
                <input type="file" name="zipfile">

                <label>Background image:</label>
                <input type="file" name="background">

                <button type="submit">Upload</button>
            </form>

        </div>

    </div>

</div>

</body>
</html>