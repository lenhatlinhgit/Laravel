@extends('layouts.admin')

@section('title', 'Change Password')
@section('page-title', 'Change Password')

@section('css')
<link rel="stylesheet" href="{{ asset('css/change.css') }}">
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

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="/changepassword" method="POST">
        @csrf

        <label>Current Password</label>
        <input type="password" name="current_password" placeholder="Enter current password">

        <label>New Password</label>
        <input type="password" name="new_password" placeholder="Enter new password">

        <label>Confirm Password</label>
        <input type="password" name="new_password_confirmation" placeholder="Confirm new password">

        <button type="submit">Update Password</button>
    </form>

</div>

@endsection