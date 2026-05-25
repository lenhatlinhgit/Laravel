@extends('layouts.admin')

@section('title', 'Edit Post')
@section('page-title', 'Edit Post')

@section('css')
<link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endsection

@section('content')
<div class="form-box">

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <form action="/post/{{ $post->id }}/update" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="text" name="title" placeholder="Title" value="{{ $post->title }}">
        <input type="text" name="location" placeholder="Location" value="{{ old('location', $locationString) }}">
        <input type="text" name="author" placeholder="Author" value="{{ $post->author }}">

        {{-- TinyMCE Editor --}}
        <label>Nội dung bài viết:</label>
        <textarea name="content" id="editor">{!! $post->content !!}</textarea>

        {{-- Background --}}
        <label>Background image (để trống nếu không đổi):</label>
        <div class="file-wrapper">
            <span class="file-name" id="bgName">Chưa chọn file</span>
            <label class="file-btn">
                Chọn file
                <input type="file" name="background"
                    onchange="bgName.textContent=this.files[0]?.name">
            </label>
        </div>

        @if($post->background)
            <p style="font-size:12px;margin-top:6px">
                Background hiện tại: 
                <img src="{{ $post->background }}" style="height:60px;border-radius:6px;vertical-align:middle">
            </p>
        @endif

        <button type="submit">Cập nhật</button>
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
</script>
@endsection