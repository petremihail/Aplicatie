<div class="container d-flex flex-column align-items-center">
    <h2 data-aos="fade-up" data-aos-delay="100">PLAN. LAUNCH. GROW.</h2>
    <p data-aos="fade-up" data-aos-delay="200">We are team of talented designers making websites with
        Bootstrap</p>
    <div class="d-flex mt-4" data-aos="fade-up" data-aos-delay="300">
        @auth
        <a href="/attendance" class="btn-get-started">Attendace</a>
        @else
        <a href="/login" class="btn-get-started">Get Started</a>
        @endauth
        {{-- <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8"
            class="glightbox btn-watch-video d-flex align-items-center"><i
                class="bi bi-play-circle"></i><span>Watch Video</span></a> --}}
    </div>
</div>
