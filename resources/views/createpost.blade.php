@extends('layouts.admin')

@section('title', 'Create Post')
@section('page-title', 'Create Post')

{{-- CSS riêng cho trang này --}}
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

        <input type="text" name="title" placeholder="Title" value="{{ old('title') }}">
        <input type="text" name="location" placeholder="Location" value="{{ old('location') }}">
        <input type="text" name="author" placeholder="Author" value="{{ old('author') }}">

        <!-- ZIP -->
        <label>ZIP file:</label>
        <div class="file-wrapper">
            <span class="file-name" id="zipName">Chưa chọn file</span>
            <label class="file-btn">
                Chọn file
                <input type="file" name="zipfile"
                onchange="zipName.textContent=this.files[0]?.name">
            </label>
        </div>

        <!-- Background -->
        <label>Background image:</label>
        <div class="file-wrapper">
            <span class="file-name" id="bgName">Chưa chọn file</span>
            <label class="file-btn">
                Chọn file
                <input type="file" name="background"
                onchange="bgName.textContent=this.files[0]?.name">
            </label>
        </div>

        <button type="submit">Upload</button>
    </form>

</div>

@endsection