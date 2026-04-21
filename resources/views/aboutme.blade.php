@extends('layouts.app')

@section('content')

<main>
            <div class="main-content">
                <div class="main-contentJourney">
                    <div class="journey-text">
                        <h2>My Journey</h2>
                        <p>Nulla quis lorem ut libero malesuada feugiat. Nulla quis lorem ut libero uada feugiat. Cras
                            ultricies ligula sed magna dictum porta. Pelleue in ipsum idhs orci porta dapibus.</p>
                        <p>Cras ultricies ligula sed magna dictum porta. Pellentesque in ipsum id orci porta dapibus.
                            Proin eget tortor risus.</p>
                    </div>
                    <div id="kk" style="background-image: url('http://127.0.0.1:8000/img/about.webp');">
                        <picture>
                            <img src="http://127.0.0.1:8000/img/about.webp" alt="My Journey" loading="lazy" />
                        </picture>
                    </div>
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
            </div>
        </main>

@endsection