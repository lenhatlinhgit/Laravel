@php
$route = request()->segment(1);
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>@yield('title')</title>

<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@yield('css')
</head>

<body>

<div class="layout">

    <!-- SIDEBAR (GIỮ NGUYÊN CSS CỦA BẠN) -->
    <div class="sidebar">
        <h2>Admin</h2>

        <a class="menu" href="/admin">
            <span class="icon">📊</span> Dashboard
        </a>

        <a class="menu" href="/createpost">
            <span class="icon">📝</span> Create Post
        </a>

        <a class="menu" href="/changepassword">
            <span class="icon">🔑</span> Change Password
        </a>

        <a class="menu" href="/logout">
            <span class="icon">🚪</span> Logout
        </a>
    </div>

    <!-- MAIN -->
    <div class="main">

        <!-- TOPBAR (IF ELSE ĐÚNG YÊU CẦU) -->
        <div class="topbar">
            <h1>

                <span class="icon">
                    @if($route == 'admin')
                        📊
                    @elseif($route == 'createpost')
                        📝
                    @elseif($route == 'changepassword')
                        🔑
                    @else
                        📄
                    @endif
                </span>

                @if($route == 'admin')
                    Dashboard
                @elseif($route == 'createpost')
                    Create Post
                @elseif($route == 'changepassword')
                    Change Password
                @else
                    Page
                @endif

            </h1>
        </div>

        <!-- STATS (GIỮ NGUYÊN NHƯ CODE BẠN) -->
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

        <!-- CONTENT -->
        @yield('content')

    </div>

</div>

@yield('script')

</body>
</html>