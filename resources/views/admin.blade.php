<a href="/logout">Logout</a>
@if ($errors->any())
    <div style="background:red; color:white; padding:10px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if(session('success'))
    <div style="padding:10px; background:green; color:white; margin-bottom:10px;">
        {{ session('success') }}
    </div>
@endif
<form action="/upload" method="POST" enctype="multipart/form-data">
    @csrf

    <input type="text" name="title" placeholder="Title"><br>
    <input type="text" name="location" placeholder="Location"><br>
    <input type="text" name="author" placeholder="Author"><br>
    <input type="date" name="dateposted"><br><br>

    <label>ZIP file:</label>
    <input type="file" name="zipfile"><br><br>

    <label>Background image:</label>
    <input type="file" name="background"><br><br>

    <button>Upload</button>
</form>