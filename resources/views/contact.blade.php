@extends('layouts.app')

@section('content')

<main>
            <div class="main-content">
                <h2 class="main-titlecontact">Get in Touch</h2>
                <picture>
                    <source srcset="./img/Contact.webp" type="image/webp">
                    <img src="./img/Contact.webp" alt="Contact" id="Contact" loading="lazy" />
                </picture>
                <div class="Contact">
                    <div class="Contact-item">
                        <p class="information">Address</p>
                        <hr />
                        <p class="detail">Mars 9 Str. 589 Leipzig, Germany</p>
                    </div>
                    <div class="Contact-item">
                        <p class="information">Phone</p>
                        <hr />
                        <p class="detail">+88-256-458-8999</p>
                    </div>
                    <div class="Contact-item">
                        <p class="information">E-mail</p>
                        <hr />
                        <p class="detail">info@journey.com</p>
                    </div>
                    <div class="Contact-item">
                        <p class="information">Fax</p>
                        <hr />
                        <p class="detail">+1-525-698-5896</p>
                    </div>
                </div>
            </div>
        </main>

@endsection