@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')

@section('css')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection

@section('content')
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
            <td>{{ $loop->iteration }}</td>
            <td>{{ $post->title }}</td>
            <td>{{ $post->author ?? 'Admin' }}</td>
            <td>{{ number_format($post->views) }}</td>
            <td>{{ $post->created_at->format('d/m/Y') }}</td>
<td class="action">

    <button class="edit"
        onclick="window.location.href='/post/{{ $post->id }}/edit'">
        Edit
    </button>

    <form action="/post/{{ $post->id }}/delete" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')

        <button class="delete"
            onclick="return confirm('Bạn có chắc muốn xóa bài viết này?')">
            Delete
        </button>
    </form>

</td>
        </tr>
        @endforeach

    </table>
</div>

@endsection