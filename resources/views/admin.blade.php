<a href="/logout">Logout</a>

{{-- 🔴 hiển thị lỗi --}}
@if ($errors->any())
    <div style="background:red; color:white; padding:10px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- 🟢 thông báo thành công --}}
@if(session('success'))
    <div style="padding:10px; background:green; color:white; margin-bottom:10px;">
        {{ session('success') }}
    </div>
@endif

<form action="/upload" method="POST" enctype="multipart/form-data">
    @csrf

    <input type="text" name="title" placeholder="Title" value="{{ old('title') }}"><br>

    <input type="text" name="location" placeholder="Location" value="{{ old('location') }}"><br>

    <input type="text" name="author" placeholder="Author" value="{{ old('author') }}"><br><br>

    <label>ZIP file:</label>
    <input type="file" name="zipfile"><br><br>

    <label>Background image:</label>
    <input type="file" name="background"><br><br>

    <button>Upload</button>
</form>