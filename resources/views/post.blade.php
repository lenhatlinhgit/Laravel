@extends('layouts.app')

@section('content')
<main class="main">
            <picture class="main-img">
                <img src="{{ asset($post->background) }}" alt="50 Amazing Adventures To Explore in Santorini"
                    loading="lazy" />
            </picture>
            <div class="main-container">
                <div class="location"><a href="{{ url('/location/' . $post->location) }}">{{ $post->location }}</a></div>
                <div class="main-titlepost">{{ $post->title }}</div>
                <div class="main-time">
                    <p>{{ $post->author }}</p>
                    <svg width="4" height="4" viewBox="0 0 8 8" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="4" cy="4" r="2" fill="currentColor" />
                    </svg>
                    <p>{{ \Carbon\Carbon::parse($post->dateposted)->format('F d, Y') }}</p>
                </div>
                {!! $post->content !!}

</div>
</main>
@endsection