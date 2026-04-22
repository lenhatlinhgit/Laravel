@extends('layouts.admin')

@section('title', 'Edit Post')
@section('page-title', 'Edit Post')

@section('css')
<link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endsection

@section('content')

<div class="form-box">

    {{-- ERROR --}}
    @if ($errors->any())
        <div class="alert-error">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    {{-- FORM --}}
    <form action="{{ url('/post/'.$post->id.'/update') }}" method="POST" enctype="multipart/form-data"
          onsubmit="return confirm('Bạn có chắc muốn cập nhật bài viết này?')">

        @csrf

        {{-- TEXT INPUT --}}
        <input type="text" name="title" value="{{ $post->title }}">
        <input type="text" name="location" value="{{ $post->location }}">
        <input type="text" name="author" value="{{ $post->author }}">

        {{-- ZIP FILE --}}
        <label>ZIP file:</label>
        <div class="file-wrapper">

            <span class="file-name">
                {{ $post->content ? basename($post->content) : 'Chưa có file' }}
            </span>

            <label class="file-btn">
                Chọn file mới
                <input type="file" name="zipfile">
            </label>

        </div>

        {{-- BACKGROUND --}}
        <label>Background image:</label>
        <div class="file-wrapper">

            <span class="file-name">
                {{ $post->background ? basename($post->background) : 'Chưa có ảnh' }}
            </span>

            <label class="file-btn">
                Chọn file mới
                <input type="file" name="background">
            </label>

        </div>

        {{-- BUTTON --}}
        <button type="submit">
            Update
        </button>

    </form>

</div>

@endsection