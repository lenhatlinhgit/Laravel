@php
$route = request()->segment(1);
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title')</title>

<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@yield('css')
</head>

<body>

<div class="layout">

    <div class="sidebar">
        <h2>Admin</h2>

        <a class="menu {{ $route == 'admin' ? 'menu-active' : '' }}" href="/admin">
            <span class="icon">📊</span> Dashboard
        </a>

        <a class="menu {{ $route == 'createpost' ? 'menu-active' : '' }}" href="/createpost">
            <span class="icon">📝</span> Create Post
        </a>

        <a class="menu {{ $route == 'crawl-sources' ? 'menu-active' : '' }}" href="/crawl-sources">
            <span class="icon">🤖</span> Crawl Sources
        </a>

        <a class="menu {{ $route == 'changepassword' ? 'menu-active' : '' }}" href="/changepassword">
            <span class="icon">🔑</span> Change Password
        </a>

        <a class="menu" href="/logout">
            <span class="icon">🚪</span> Logout
        </a>
    </div>

    <div class="main">

        <div class="topbar">
            <h1>
                <span class="icon">
                    @if($route == 'admin')             📊
                    @elseif($route == 'createpost')    📝
                    @elseif($route == 'crawl-sources') 🤖
                    @elseif($route == 'changepassword') 🔑
                    @else                              📄
                    @endif
                </span>
                @if($route == 'admin')             Dashboard
                @elseif($route == 'createpost')    Create Post
                @elseif($route == 'crawl-sources') Crawl Sources
                @elseif($route == 'changepassword') Change Password
                @else                              Page
                @endif
            </h1>
        </div>

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

        @yield('content')

    </div>

</div>

@yield('script')

</body>
</html>