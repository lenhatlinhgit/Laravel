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
@if ($posts->hasPages())
    <nav class="pages" style="padding-bottom: 30px;">
        <ul>

            {{-- Prev --}}
            @if (!$posts->onFirstPage())
                <li><a href="{{ $posts->previousPageUrl() }}">Prev</a></li>
            @endif

            {{-- Số trang --}}
            @for ($i = 1; $i <= $posts->lastPage(); $i++)
                @if ($i == $posts->currentPage())
                    <li class="current-page"><span>{{ $i }}</span></li>
                @else
                    <li><a href="{{ $posts->url($i) }}">{{ $i }}</a></li>
                @endif
            @endfor

            {{-- Next --}}
            @if ($posts->hasMorePages())
                <li><a href="{{ $posts->nextPageUrl() }}">Next</a></li>
            @endif

        </ul>
    </nav>
@endif
</main>

@endsection