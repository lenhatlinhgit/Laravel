@extends('layouts.admin')

@section('title', 'Create Post')
@section('page-title', 'Create Post')

@section('css')
<link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endsection

@section('content')
<div class="form-box">

    @if ($errors->any())
        <div class="alert-error">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="/upload" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="input-group" style="display:flex;gap:8px;align-items:center;">
            <input type="url" name="source_url" id="source_url" placeholder="Paste URL for Link Preview" value="{{ old('source_url') }}" style="flex:1;min-width:0;">
            <button type="button" id="fetchSeoBtn" style="white-space:nowrap;">Link Preview</button>
        </div>

        <input type="text" name="title" id="title" placeholder="Title" value="{{ old('title') }}">
        <input type="text" name="location" id="location" placeholder="Location" value="{{ old('location') }}">
        <input type="text" name="author" id="author" placeholder="Author" value="{{ old('author') }}">

        {{-- TinyMCE Editor --}}
        <label>Nội dung bài viết:</label>
        <textarea name="content" id="editor">{{ old('content') }}</textarea>

        {{-- Background --}}
        <label>Background image:</label>
        <div class="file-wrapper">
            <span class="file-name" id="bgName">Chưa chọn file</span>
            <label class="file-btn">
                Chọn file
                <input type="file" name="background"
                    onchange="bgName.textContent=this.files[0]?.name">
            </label>
        </div>

        <button type="submit">Đăng bài</button>
    </form>
</div>
@endsection

@section('script')
<script src="/build/vendor/node_modules/tinymce/tinymce.min.js"></script>
<script>
tinymce.init({
    selector: '#editor',
    height: 500,
    promotion: false,
    convert_urls: false,
    relative_urls: false,
    plugins: 'image link lists table code fullscreen preview wordcount',
    toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image | table | code fullscreen',
    images_upload_url: '/editor/image',
    images_upload_credentials: true,
    setup: function(editor) {
        editor.on('change', function() {
            editor.save();
        });
    },
    images_upload_handler: function(blobInfo, progress) {
        return new Promise(function(resolve, reject) {
            const formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            formData.append('_token', '{{ csrf_token() }}');

            fetch('/editor/image', {
                method: 'POST',
                body: formData,
            })
            .then(r => r.json())
            .then(data => resolve(data.location))
            .catch(() => reject('Upload ảnh thất bại'));
        });
    }
});

const fetchSeoBtn = document.getElementById('fetchSeoBtn');
if (fetchSeoBtn) {
    fetchSeoBtn.addEventListener('click', async function () {
        const urlField = document.getElementById('source_url');
        const titleField = document.getElementById('title');
        const locationField = document.getElementById('location');
        const authorField = document.getElementById('author');
        const editorField = document.getElementById('editor');
        const url = urlField.value.trim();

        if (!url) {
            alert('Vui lòng nhập URL trước khi lấy dữ liệu.');
            return;
        }

        fetchSeoBtn.disabled = true;
        fetchSeoBtn.textContent = 'Previewing...';

        try {
            const token = document.querySelector('input[name="_token"]').value;
            const response = await fetch('/fetch-seo', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token,
                },
                body: JSON.stringify({ url }),
            });

            let data;
            try {
                data = await response.json();
            } catch (parseError) {
                const text = await response.text();
                console.error('fetch-seo response parse error:', parseError, text);
                alert('Không thể lấy dữ liệu từ URL. Server trả về dữ liệu không hợp lệ.');
                return;
            }

            if (!response.ok) {
                const message = data.error || (data.errors ? Object.values(data.errors).flat()[0] : null) || response.statusText;
                alert(message || 'Không thể lấy dữ liệu từ URL.');
                return;
            }

            if (data.title) {
                titleField.value = data.title;
            }
            if (data.location) {
                locationField.value = data.location;
            }
            if (data.author) {
                authorField.value = data.author;
            }
            if (data.content) {
                editorField.value = data.content;
                tinymce.get('editor')?.setContent(data.content);
            }
        } catch (error) {
            alert('Lỗi khi lấy dữ liệu từ URL.');
        } finally {
            fetchSeoBtn.disabled = false;
            fetchSeoBtn.textContent = 'Link Preview';
        }
    });
}
</script>
@endsection