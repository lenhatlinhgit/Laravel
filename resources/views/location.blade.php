@extends('layouts.app')

@section('content')

<main>
            <div class="main-content">
                <h2 class="Category">Category: {{ $location }}</h2>
                <div class="main-components">
                    @foreach($posts as $post)
                    <div class="main-component">
                        <div class="main-componentimg">
                            <a href="{{ url('/post/' . $post->id) }}">
                                <picture>
                                    <img src="{{ $post->background }}" loading="lazy" alt="image Europe" />
                                </picture>
                            </a>
                        </div>
                        <div class="main-componentcontent">
                            <div class="location"><a href="{{ url('/location/' . $post->location) }}">{{ $post->location }}</a></div>
                            <h3 class="title"><a href="{{ url('/post/' . $post->id) }}">{{ $post->title }}</a></h3>
                            <p class="time">{{ \Carbon\Carbon::parse($post->dateposted)->format('F d, Y') }}</p>
                            <p class="intro">Aitae lectus dapibus nisl bibendum erat. Si sagittis laoreet nisl integer
                                letius
                                feugiat praesent vehicula nisi ornare. Inceptos rutrum libero integer laoreet senectus
                                fames.</p>
                            <div class="readmore"><a href="{{ url('/post/' . $post->id) }}">Read More</a></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
</main>

@endsection