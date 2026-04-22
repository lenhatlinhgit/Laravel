<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>

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

    position: fixed;   /* 👈 dính luôn */
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
    overflow: hidden; /* 👈 CHẶN tràn */
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

/* TABLE */
.table {
    background: #fff;
    border: 1px solid rgba(0,0,0,0.05);

    flex: 1;              /* 👈 chiếm phần còn lại */
    overflow-y: auto;     /* 👈 CHỈ TABLE CUỘN */
    margin-bottom: 50px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 14px;
    font-size: 14px;
    border-bottom: 1px solid rgba(0,0,0,0.05);
}

th {
    background: #faf9f6;
    text-align: left;
}

/* ACTION */
.action button {
    margin-right: 5px;
    padding: 6px 10px;
    font-size: 12px;
    cursor: pointer;
}

.edit {
    background: #f8f5ef;
    border: 1px solid rgba(0,0,0,0.1);
}

.delete {
    background: #fff;
    border: 1px solid rgba(0,0,0,0.2);
}

.icon {
    font-size: 16px;
    position: relative;
    top: 1px;
}
</style>
</head>

<body>

<div class="layout">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>Admin</h2>

        <a class="menu" href="/admin"><span class="icon">📊</span> Dashboard</a>
        <a class="menu" href="/createpost"><span class="icon">📝</span> Posts</a>
        <a class="menu" href="#"><span class="icon">🔑</span> Change Password</a>
        <a class="menu" href="/logout"><span class="icon">🚪</span> Logout</a>
    </div>

    <!-- MAIN -->
    <div class="main">

        <div class="topbar">
            <h1><span class="icon">📊</span> Dashboard</h1>
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

        <!-- TABLE -->
<div class="table">
    <table>
        <tr>
            <th>STT</th>
            <th>Post</th>
            <th>Author</th>
            <th>Views</th>
            <th>Date</th>
            <th>Action</th>
        </tr>

        @foreach($posts as $post)
        <tr>
            <td>{{ $loop->iteration }}</td> {{-- 👈 STT --}}
            <td>{{ $post->title }}</td>
            <td>{{ $post->author ?? 'Admin' }}</td>
            <td>{{ number_format($post->views) }}</td>
            <td>{{ $post->created_at->format('d/m/Y') }}</td>
            <td class="action">
                <button class="edit">Edit</button>
                <button class="delete">Delete</button>
            </td>
        </tr>
        @endforeach

    </table>
</div>

    </div>

</div>

</body>
</html>