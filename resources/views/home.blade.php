@extends('layouts.app')

@section('content')
<main>
            <div class="img-headmain" style="background-image: url('{{ asset('img/journey_bg.webp') }}');">
                <div class="img-headmaincontent">
                    <p class="img-headmaincontent1">Hey! I’m Taylor,</p>
                    <h2 class="img-headmaincontent2">A Traveler Exploring Beautiful World</h2>
                    <p class="img-headmaincontent3">Nulla porttitor accumsan tincidunt. Curabitur non nulla sit amet
                        nisl tempusdvae convallis quis
                        ac lectus.Vivamus magna justo</p>
                    <div class="img-headmainbutton"><a href="./index.html">Learn More</a></div>
                </div>
            </div>
            <div class="main-content">
                <h2 class="main-title">Recent Posts</h2>
                <p class="text">Sed porttitor lectus nibh. Lorem ipsum dolor sit amet, consectetur
                    adipiscingelit. Curabitur arcuerat.</p>
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
                            <div class="location"><a href="./Europe.html">{{ $post->location }}</a></div>
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
                <nav class="pages">
                    <ul>
                        <li class="current-page"><span>1</span></li>
                        <li><a href="./indexpage2.html">2</a></li>
                        <li><a href="./indexpage3.html">3</a></li>
                        <li><a href="./indexpage4.html">4</a></li>
                        <li><a href="./indexpage2.html">Next</a></li>
                    </ul>
                </nav>
                <div class="banner">
                    <picture>
                        <source srcset="./img/banner.webp" type="image/webp">
                        <img src="./img/banner.avif" loading="lazy" alt="banner" />
                    </picture>
                </div>
                <h2 class="main-title">Latest Videos</h2>
                <p class="text">Sed porttitor lectus nibh. Lorem ipsum dolor sit amet, consectetur adipiscing
                    elit. Curabitur arcu erat.</p>
                <div class="main-video">
                    <div class="main-videoitem">
                        <video controls>
                            <source src="./img/advetures.mp4" type="video/mp4">
                            Trình duyệt không hỗ trợ video.
                        </video>
                        <h3>25 Most Beautiful Destination in Europe</h3>
                    </div>
                    <div class="main-videoitem">
                        <video controls>
                            <source src="./img/surfing_video.mp4" type="video/mp4">
                            Trình duyệt không hỗ trợ video.
                        </video>
                        <h3>My Solo Trip to Hills, The Perfect Getaway</h3>
                    </div>
                    <div class="main-videoitem">
                        <video controls>
                            <source src="./img/hiking.mp4" type="video/mp4">
                            Trình duyệt không hỗ trợ video.
                        </video>
                        <h3>7 Adventures to Try While you Travel to Asia</h3>
                    </div>
                </div>
                <h2 class="main-title">Follow @journey</h2>
                <div class="gallery">
                    <picture>
                        <source srcset="./img/gallery_1.webp" type="image/webp">
                        <img src="./img/gallery_1.webp" loading="lazy" alt="gallery" />
                    </picture>
                    <picture>
                        <source srcset="./img/gallery_2.webp" type="image/webp">
                        <img src="./img/gallery_2.webp" loading="lazy" alt="gallery" />
                    </picture>
                    <picture>
                        <source srcset="./img/gallery_3.webp" type="image/webp">
                        <img src="./img/gallery_3.webp" loading="lazy" alt="gallery" />
                    </picture>
                    <picture>
                        <source srcset="./img/gallery_4.webp" type="image/webp">
                        <img src="./img/gallery_4.webp" loading="lazy" alt="gallery" />
                    </picture>
                    <picture>
                        <source srcset="./img/gallery_5.webp" type="image/webp">
                        <img src="./img/gallery_5.webp" loading="lazy" alt="gallery" />
                    </picture>
                    <picture>
                        <source srcset="./img/gallery_6.webp" type="image/webp">
                        <img src="./img/gallery_6.webp" loading="lazy" alt="gallery" />
                    </picture>
                </div>
            </div>
        </main>
@endsection