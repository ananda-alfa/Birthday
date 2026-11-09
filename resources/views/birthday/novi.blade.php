@use('App\Support\BirthdayGift')
@php
    /*
     | Foto kenangan untuk galeri.
     | Ganti file di public/birthday/images/ (nama file sama), lalu ubah caption di sini bila perlu.
     */
    $memories = [
        ['file' => 'novi-1.jpg', 'caption' => 'Senyummu, hal favoritku setiap hari.'],
        ['file' => 'novi-2.jpg', 'caption' => 'Momen kecil yang selalu ingin kuulang.'],
        ['file' => 'novi-3.jpg', 'caption' => 'Bersamamu, waktu terasa terlalu cepat.'],
        ['file' => 'novi-4.jpg', 'caption' => 'Tawa yang selalu kurindukan.'],
        ['file' => 'novi-5.jpg', 'caption' => 'Satu dari sekian banyak hari bahagia.'],
        ['file' => 'novi-6.jpg', 'caption' => 'Dan masih banyak cerita yang menanti.'],
    ];

    $chapters = [
        'hero' => 'Opening',
        'intro' => 'For You',
        'letter' => 'Love Letter',
        'gallery' => 'Memories',
        'cake' => 'Make a Wish',
        'surprise' => 'Surprise',
        'gift' => 'Your Gift',
        'finale' => 'Happy Birthday',
    ];
    $totalChapters = count($chapters);

    $giftOptions = BirthdayGift::options();
    $giftData = [
        'options' => $giftOptions,
        'choice' => BirthdayGift::current(),
        'url' => route('birthday.novi.gift'),
    ];
    $giftBoxColors = [
        ['#F8BBD0', '#EFA3BD', '#C65F85'],
        ['#FFFFFF', '#FCE4EC', '#EFA3BD'],
        ['#EFA3BD', '#C65F85', '#FCE4EC'],
        ['#FCE4EC', '#F8BBD0', '#F4C989'],
    ];
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>Happy Birthday, Novi ♡</title>
    <meta name="description" content="Sebuah hadiah kecil, dibuat dengan penuh cinta untuk Novi.">
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="#F8BBD0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta property="og:type" content="website">
    <meta property="og:title" content="Happy Birthday, Novi ♡">
    <meta property="og:description" content="Today is all about you, beautiful.">
    <meta property="og:image" content="{{ asset('birthday/images/novi-1.jpg') }}">

    <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%23C65F85' d='M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z'/%3E%3C/svg%3E">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400;1,500&family=Poppins:wght@300;400;500;600&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('birthday/css/style.css') }}">

    <script>document.documentElement.classList.add('js', 'story-mode');</script>
</head>
<body>

    {{-- ============ SVG sprite: bunga, daun, hati, kilau (dipakai ulang di seluruh halaman) ============ --}}
    <svg class="svg-sprite" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <defs>
            <g id="g-flower">
                <ellipse rx="16" ry="25" cy="-22"/>
                <ellipse rx="16" ry="25" cy="-22" transform="rotate(72)"/>
                <ellipse rx="16" ry="25" cy="-22" transform="rotate(144)"/>
                <ellipse rx="16" ry="25" cy="-22" transform="rotate(216)"/>
                <ellipse rx="16" ry="25" cy="-22" transform="rotate(288)"/>
                <g fill="#FFFFFF" fill-opacity=".38">
                    <ellipse rx="7" ry="13" cy="-20"/>
                    <ellipse rx="7" ry="13" cy="-20" transform="rotate(72)"/>
                    <ellipse rx="7" ry="13" cy="-20" transform="rotate(144)"/>
                    <ellipse rx="7" ry="13" cy="-20" transform="rotate(216)"/>
                    <ellipse rx="7" ry="13" cy="-20" transform="rotate(288)"/>
                </g>
                <circle r="10" fill="#F6D58E"/>
                <circle r="4.5" fill="#E8B15C"/>
            </g>
            <path id="g-leaf" d="M0 0C12-16 38-22 62-10 40 2 18 6 0 0Z"/>
            <path id="g-heart" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
        </defs>

        <symbol id="i-heart" viewBox="0 0 24 24"><use href="#g-heart"/></symbol>
        <symbol id="i-flower" viewBox="-50 -50 100 100"><use href="#g-flower"/></symbol>
        <symbol id="i-petal" viewBox="0 0 24 24"><path d="M12 2C7 6 5 11 7 16c1.3 3.2 3.4 5 5 6 1.6-1 3.7-2.8 5-6 2-5 0-10-5-14z"/></symbol>
        <symbol id="i-sparkle" viewBox="0 0 24 24"><path d="M12 0c1 8 4 11 12 12-8 1-11 4-12 12-1-8-4-11-12-12 8-1 11-4 12-12z"/></symbol>

        {{-- Rangkaian bunga untuk sudut (didesain untuk pojok kiri atas, dicerminkan via CSS) --}}
        <symbol id="i-spray" viewBox="0 0 240 240">
            <g fill="none" stroke="#9DBF9E" stroke-width="2.2" stroke-linecap="round">
                <path d="M4 4C58 34 92 92 118 176"/>
                <path d="M4 4C52 26 124 36 200 70"/>
                <path d="M30 20C34 62 30 100 22 138"/>
            </g>
            <g fill="#A9CBA4">
                <use href="#g-leaf" transform="translate(96 110) rotate(-62) scale(.7)"/>
                <use href="#g-leaf" transform="translate(112 150) rotate(-110) scale(.6)"/>
                <use href="#g-leaf" transform="translate(150 50) rotate(-20) scale(.62)"/>
                <use href="#g-leaf" transform="translate(28 96) rotate(200) scale(.55)"/>
            </g>
            <g fill="#8DB596">
                <use href="#g-leaf" transform="translate(110 44) rotate(28) scale(.6)"/>
                <use href="#g-leaf" transform="translate(70 104) rotate(120) scale(.5)"/>
                <use href="#g-leaf" transform="translate(176 62) rotate(40) scale(.45)"/>
            </g>
            <use href="#g-flower" transform="translate(70 62) scale(.95) rotate(12)" fill="#EFA3BD"/>
            <use href="#g-flower" transform="translate(146 56) scale(.6) rotate(-8)" fill="#F8BBD0"/>
            <use href="#g-flower" transform="translate(110 138) scale(.56) rotate(30)" fill="#C65F85"/>
            <use href="#g-flower" transform="translate(30 124) scale(.42)" fill="#F8BBD0"/>
            <circle cx="198" cy="72" r="6" fill="#EFA3BD"/>
            <circle cx="120" cy="178" r="5" fill="#F8BBD0"/>
            <circle cx="22" cy="146" r="4" fill="#C65F85"/>
            <g fill="#F4C989">
                <circle cx="186" cy="40" r="2.5"/><circle cx="60" cy="150" r="2"/><circle cx="150" cy="104" r="2.2"/>
            </g>
        </symbol>
    </svg>

    {{-- Lapisan hati & kelopak yang melayang (diisi oleh JavaScript) --}}
    <div class="ambient" data-ambient aria-hidden="true"></div>
    <canvas id="confetti-canvas" class="confetti-canvas" aria-hidden="true"></canvas>

    {{-- Navigasi titik (desktop) --}}
    <nav class="dot-nav" aria-label="Navigasi bagian">
        <ul>
            @foreach ($chapters as $id => $label)
                <li>
                    <a href="#{{ $id }}" class="dot-nav__link" data-dot-link data-story-goto="{{ $id }}" data-label="{{ $label }}" aria-label="{{ $label }}"></a>
                </li>
            @endforeach
        </ul>
    </nav>

    {{-- Navigasi halaman: Back / Next (mode cerita, diaktifkan oleh JavaScript) --}}
    <div class="story-progress" aria-hidden="true"><span data-story-progress></span></div>

    <button type="button" class="scroll-hint" data-scroll-hint aria-label="Gulir ke bawah">
        <i class="bi bi-chevron-double-down" aria-hidden="true"></i>
    </button>

    <nav class="story-nav is-hidden" data-story-nav aria-label="Navigasi halaman">
        <button type="button" class="story-nav__prev" data-story-prev aria-label="Halaman sebelumnya">
            <i class="bi bi-chevron-left" aria-hidden="true"></i>
        </button>
        <span class="story-nav__counter" data-story-counter aria-live="polite">1 / {{ $totalChapters }}</span>
        <button type="button" class="story-nav__next" data-story-next>
            <span data-story-next-label>Next</span>
            <i class="bi bi-chevron-right" aria-hidden="true"></i>
        </button>
    </nav>

    {{-- ===================== SECTION 1 — OPENING ===================== --}}
    <header id="hero" class="hero is-active" data-slide tabindex="-1">
        <div class="slide-decor" aria-hidden="true">
        <div class="hero__glow hero__glow--one" aria-hidden="true"></div>
        <div class="hero__glow hero__glow--two" aria-hidden="true"></div>
        <div class="hero__glow hero__glow--three" aria-hidden="true"></div>

        <div class="hero__floral hero__floral--tl" data-parallax="0.12" aria-hidden="true">
            <svg class="floral-spray"><use href="#i-spray"/></svg>
        </div>
        <div class="hero__floral hero__floral--tr floral-spray--mirror-x" data-parallax="0.18" aria-hidden="true">
            <svg class="floral-spray"><use href="#i-spray"/></svg>
        </div>
        <div class="hero__floral hero__floral--bl floral-spray--mirror-y" data-parallax="-0.06" aria-hidden="true">
            <svg class="floral-spray"><use href="#i-spray"/></svg>
        </div>
        <div class="hero__floral hero__floral--br floral-spray--mirror-xy" data-parallax="-0.1" aria-hidden="true">
            <svg class="floral-spray"><use href="#i-spray"/></svg>
        </div>

        <div class="sparkle-field" data-sparkles="22" aria-hidden="true"></div>
        </div>

        <div class="container hero__content">
            <p class="eyebrow hero__item" style="--i: 0">A Special Day For Someone Special</p>

            <h1 class="hero__heading">
                <span class="hero__title hero__item" style="--i: 1">Happy Birthday</span>
                <span class="hero__name hero__item" style="--i: 2">Novi</span>
            </h1>

            <svg class="hero__flourish hero__item" style="--i: 3" viewBox="0 0 320 40" aria-hidden="true">
                <path d="M10 22C60 4 100 36 150 20c10-3 14-10 10-12-5-2-12 4-6 10 8 8 30 2 46-4 40-15 70 6 100-2"/>
            </svg>

            <p class="hero__subtitle hero__item" style="--i: 4">Today is all about you, beautiful.</p>

            <div class="hero__item" style="--i: 5">
                <button type="button" class="btn-love btn-love--lg" data-open-surprise data-story-goto="intro">
                    <span>Open Your Surprise</span>
                    <svg class="btn-love__heart" aria-hidden="true"><use href="#i-heart"/></svg>
                </button>
            </div>
        </div>
    </header>

    <main>

        {{-- ===================== SECTION 2 — INTRODUCTION ===================== --}}
        <section id="intro" class="section section--intro" aria-labelledby="intro-title" data-slide data-next-label="Read My Letter" tabindex="-1">
            <div class="sparkle-field" data-sparkles="14" data-sparkle-color="#EFA3BD" aria-hidden="true"></div>

            <div class="container">
                <div class="row align-items-center gy-5 gx-lg-5">
                    <div class="col-lg-6 order-lg-2 text-center text-lg-start">
                        <p class="eyebrow reveal">Chapter One</p>
                        <h2 id="intro-title" class="section-title reveal" style="--d: 1">To My Favorite Person</h2>
                        <div class="ornament ornament--start reveal" style="--d: 2" aria-hidden="true">
                            <span></span><svg><use href="#i-heart"/></svg><span></span>
                        </div>
                        <p class="lead-text reveal" style="--d: 3">
                            Dari sekian banyak orang yang hadir dalam hidup ini, aku bersyukur bisa mengenal seseorang seperti kamu.
                        </p>
                        <p class="script-note reveal" style="--d: 4">and that someone is you, Novi ♡</p>
                    </div>

                    <div class="col-lg-6 order-lg-1">
                        <div class="intro-art reveal" aria-hidden="true">
                            <div class="intro-art__ring"></div>
                            <div class="intro-art__circle"></div>
                            <svg class="intro-art__heart" viewBox="0 0 24 24">
                                <defs>
                                    <linearGradient id="heartGradient" x1="0" y1="0" x2="1" y2="1">
                                        <stop offset="0" stop-color="#F8BBD0"/>
                                        <stop offset=".55" stop-color="#EFA3BD"/>
                                        <stop offset="1" stop-color="#C65F85"/>
                                    </linearGradient>
                                </defs>
                                <use href="#g-heart" fill="url(#heartGradient)"/>
                            </svg>
                            <svg class="intro-art__spray intro-art__spray--left floral-spray--mirror-y"><use href="#i-spray"/></svg>
                            <svg class="intro-art__spray intro-art__spray--right floral-spray--mirror-xy"><use href="#i-spray"/></svg>
                            <svg class="mini-heart mini-heart--1"><use href="#i-heart"/></svg>
                            <svg class="mini-heart mini-heart--2"><use href="#i-heart"/></svg>
                            <svg class="mini-heart mini-heart--3"><use href="#i-heart"/></svg>
                            <svg class="mini-heart mini-heart--4"><use href="#i-heart"/></svg>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ===================== SECTION 3 — LOVE LETTER ===================== --}}
        <section id="letter" class="section section--letter" aria-labelledby="letter-title" data-slide data-next-label="Our Memories" tabindex="-1">
            <div class="container">
                <header class="section-head text-center">
                    <p class="eyebrow reveal">Chapter Two</p>
                    <h2 id="letter-title" class="section-title reveal" style="--d: 1">A Letter, Just For You</h2>
                </header>

                <article class="love-letter reveal">
                    <svg class="love-letter__floral love-letter__floral--tl" aria-hidden="true"><use href="#i-spray"/></svg>
                    <svg class="love-letter__floral love-letter__floral--br floral-spray--mirror-xy" aria-hidden="true"><use href="#i-spray"/></svg>
                    <span class="love-letter__seal" aria-hidden="true"><svg><use href="#i-heart"/></svg></span>

                    <div class="love-letter__inner">
                        <p class="love-letter__greeting reveal">Dear Novi,</p>
                        <p class="love-letter__highlight reveal" style="--d: 1">Happy birthday, sayang. ❤️</p>

                        <div class="love-letter__body">
                            <p class="reveal">Hari ini adalah hari spesial karena seseorang yang begitu berarti sedang bertambah usia.</p>
                            <p class="reveal">Aku cuma ingin kamu tahu betapa berharganya dirimu.</p>
                            <p class="reveal">Terima kasih sudah hadir, sudah menjadi dirimu sendiri, dan sudah memberikan banyak warna dalam hari-hariku.</p>
                            <p class="reveal">Semoga di usia yang baru ini, semua hal baik datang menghampirimu. Semoga semua impianmu satu per satu menjadi nyata, langkahmu selalu dimudahkan, dan hatimu selalu punya alasan untuk tersenyum.</p>
                            <p class="reveal">Kalau suatu hari dunia terasa melelahkan, semoga kamu selalu ingat bahwa ada seseorang yang akan selalu mendoakan kebahagiaanmu.</p>
                            <p class="reveal">Jangan pernah berhenti menjadi Novi yang luar biasa.</p>
                        </div>

                        <p class="love-letter__signoff reveal">With all my love ❤️</p>
                    </div>
                </article>
            </div>
        </section>

        {{-- ===================== SECTION 4 — MEMORY GALLERY ===================== --}}
        <section id="gallery" class="section section--gallery" aria-labelledby="gallery-title" data-slide data-next-label="Make a Wish" tabindex="-1">
            <div class="container">
                <header class="section-head text-center">
                    <p class="eyebrow reveal">Chapter Three</p>
                    <h2 id="gallery-title" class="section-title reveal" style="--d: 1">Our Beautiful Memories</h2>
                    <p class="section-sub reveal" style="--d: 2">Setiap foto menyimpan cerita, dan di setiap cerita selalu ada kamu.</p>
                </header>

                <div class="gallery-strip">
                <div class="row g-4 g-xl-5 gallery-track" data-gallery-track data-swipe-ignore>
                    @foreach ($memories as $index => $memory)
                        <div class="col-12 col-md-6 col-lg-4">
                            <figure class="memory reveal" style="--d: {{ $index % 3 }}">
                                <button type="button"
                                        class="memory__frame"
                                        data-lightbox-item
                                        data-src="{{ asset('birthday/images/' . $memory['file']) }}"
                                        data-caption="{{ $memory['caption'] }}"
                                        aria-label="Perbesar foto kenangan {{ $index + 1 }}">
                                    <img src="{{ asset('birthday/images/' . $memory['file']) }}"
                                         alt="Foto kenangan {{ $index + 1 }}: {{ $memory['caption'] }}"
                                         width="1200" height="1500"
                                         loading="lazy" decoding="async"
                                         data-fallback>
                                    <span class="memory__overlay" aria-hidden="true"><i class="bi bi-arrows-angle-expand"></i></span>
                                </button>
                                <figcaption class="memory__caption">{{ $memory['caption'] }}</figcaption>
                            </figure>
                        </div>
                    @endforeach
                </div>

                    <button type="button" class="gallery-strip__btn gallery-strip__btn--prev" data-gallery-prev aria-label="Geser ke foto sebelumnya">
                        <i class="bi bi-chevron-left" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="gallery-strip__btn gallery-strip__btn--next" data-gallery-next aria-label="Geser ke foto berikutnya">
                        <i class="bi bi-chevron-right" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </section>

        {{-- ===================== SECTION 5 — BIRTHDAY CAKE ===================== --}}
        <section id="cake" class="section section--cake" aria-labelledby="cake-title" data-slide data-next-label="One More Surprise" tabindex="-1">
            <div class="sparkle-field" data-sparkles="16" data-sparkle-color="#F4C989" aria-hidden="true"></div>

            <div class="container text-center">
                <header class="section-head">
                    <p class="eyebrow reveal">Chapter Four</p>
                    <h2 id="cake-title" class="section-title section-title--script reveal" style="--d: 1">Make a Wish, Novi</h2>
                    <p class="section-sub reveal" style="--d: 2">Pejamkan mata, ucapkan permohonanmu dalam hati, lalu tiup lilinnya ♡</p>
                </header>

                <div class="cake-stage reveal" data-cake>
                    <div class="cake-stage__glow" aria-hidden="true"></div>

                    <div class="cake" role="img" aria-label="Kue ulang tahun dengan tiga lilin menyala">
                        <div class="cake__candles">
                            @foreach ([1, 2, 3] as $candle)
                                <span class="candle candle--{{ $candle }}">
                                    <span class="candle__flame"></span>
                                    <span class="candle__smoke"></span>
                                </span>
                            @endforeach
                        </div>
                        <div class="cake__tier cake__tier--top">
                            <span class="cake__dots"></span>
                        </div>
                        <div class="cake__tier cake__tier--bottom">
                            <span class="cake__label">Novi</span>
                            <span class="cake__pearls"></span>
                        </div>
                        <div class="cake__plate"></div>
                    </div>
                </div>

                <p class="wish-message" data-wish-message data-text="May all your wishes come true! ✨" aria-live="polite"></p>

                <button type="button" class="btn-love btn-love--lg" data-wish-button>
                    <i class="bi bi-stars" data-wish-icon aria-hidden="true"></i>
                    <span data-wish-label>Make a Wish</span>
                </button>
            </div>
        </section>

        {{-- ===================== SECTION 6 — LOVE ENVELOPE ===================== --}}
        <section id="surprise" class="section section--surprise" aria-labelledby="surprise-title" data-slide data-next-label="Pick Your Gift" tabindex="-1">
            <div class="container text-center">
                <header class="section-head">
                    <p class="eyebrow reveal">Chapter Five</p>
                    <h2 id="surprise-title" class="section-title reveal" style="--d: 1">A Little Surprise</h2>
                    <p class="section-sub reveal" style="--d: 2">Ada sesuatu di dalam amplop ini, khusus untukmu.</p>
                </header>

                <div class="envelope-stage reveal">
                    <button type="button"
                            class="envelope"
                            data-envelope
                            aria-haspopup="dialog"
                            aria-expanded="false"
                            aria-label="Buka amplop kejutan">
                        <span class="envelope__back"></span>
                        <span class="envelope__letter">
                            <span class="envelope__letter-title">For You, Novi</span>
                            <svg class="envelope__letter-heart" aria-hidden="true"><use href="#i-heart"/></svg>
                        </span>
                        <span class="envelope__pocket"></span>
                        <span class="envelope__flap"></span>
                        <span class="envelope__seal"><svg aria-hidden="true"><use href="#i-heart"/></svg></span>
                    </button>

                    <p class="envelope-hint" data-envelope-hint data-default="Tap the envelope ♡">Tap the envelope ♡</p>

                    <button type="button" class="btn-ghost" data-envelope-reset hidden>
                        <i class="bi bi-envelope-heart" aria-hidden="true"></i>
                        <span>Tutup Amplop</span>
                    </button>
                </div>
            </div>
        </section>

        {{-- ===================== SECTION 6B — GIFT GACHA ===================== --}}
        <section id="gift" class="section section--gift" aria-labelledby="gift-title" data-slide data-next-label="Last Page" tabindex="-1">
            <div class="slide-decor" aria-hidden="true">
                <div class="sparkle-field" data-sparkles="16" data-sparkle-color="#F4C989"></div>
            </div>

            <div class="container text-center">
                <header class="section-head">
                    <p class="eyebrow reveal">Chapter Six</p>
                    <h2 id="gift-title" class="section-title reveal" style="--d: 1">Pick Your Gift</h2>
                    <p class="section-sub reveal" style="--d: 2" data-gacha-instruction aria-live="polite">
                        Ada {{ count($giftOptions) }} hadiah tersembunyi di dalam kotak. Acak dulu, lalu pilih satu kotak. Isinya jadi hadiahmu ♡
                    </p>
                </header>

                <div class="gacha reveal" style="--d: 3" data-gacha>
                    @foreach ($giftOptions as $index => $gift)
                        @php([$boxColor, $boxShade, $ribbonColor] = $giftBoxColors[$index % count($giftBoxColors)])
                        <button type="button"
                                class="gift-box"
                                data-gift-box="{{ $index }}"
                                style="--box: {{ $boxColor }}; --box-dark: {{ $boxShade }}; --ribbon: {{ $ribbonColor }}"
                                aria-label="Kotak hadiah {{ $index + 1 }}"
                                disabled>
                            <span class="gift-box__visual" aria-hidden="true">
                                <span class="gift-box__item">
                                    <span class="gift-box__emoji" data-gift-emoji></span>
                                </span>
                                <span class="gift-box__label" data-gift-label></span>
                                <span class="gift-box__body"><span class="gift-box__mark">?</span></span>
                                <span class="gift-box__lid"></span>
                            </span>
                        </button>
                    @endforeach
                </div>

                <button type="button" class="btn-love btn-love--lg" data-gacha-shuffle>
                    <i class="bi bi-shuffle" aria-hidden="true"></i>
                    <span data-gacha-shuffle-label>Acak Hadiahnya</span>
                </button>

                <div class="gift-summary" data-gift-summary hidden>
                    <p class="gift-summary__text">Hadiahmu: <strong data-gift-summary-label></strong></p>
                    <button type="button" class="btn-ghost" data-gift-show>
                        <i class="bi bi-gift" aria-hidden="true"></i>
                        <span>Lihat Lagi</span>
                    </button>
                </div>
            </div>
        </section>

        {{-- ===================== SECTION 7 — FINALE ===================== --}}
        <section id="finale" class="section section--finale" aria-labelledby="finale-title" data-slide tabindex="-1">
            <div class="slide-decor" aria-hidden="true">
                <div class="sparkle-field" data-sparkles="24"></div>
                <svg class="finale__floral finale__floral--tl"><use href="#i-spray"/></svg>
                <svg class="finale__floral finale__floral--br floral-spray--mirror-xy"><use href="#i-spray"/></svg>
            </div>

            <div class="container text-center">
                <div class="finale__heart reveal" aria-hidden="true">
                    <span class="finale__heart-ring"></span>
                    <span class="finale__heart-ring finale__heart-ring--late"></span>
                    <svg><use href="#i-heart"/></svg>
                </div>

                <h2 id="finale-title" class="finale__title reveal" style="--d: 1">
                    Once Again, Happy Birthday
                    <span class="finale__script">My Favorite Person</span>
                </h2>

                <p class="finale__text reveal" style="--d: 2">
                    Semoga hari ini menjadi salah satu kenangan terindah yang selalu kamu ingat.
                </p>

                <div class="finale__actions reveal" style="--d: 3">
                    <button type="button" class="btn-love btn-love--light" data-celebrate>
                        <span>Send More Love</span>
                        <svg class="btn-love__heart" aria-hidden="true"><use href="#i-heart"/></svg>
                    </button>
                    <a href="#hero" class="btn-ghost btn-ghost--light" data-story-goto="hero">
                        <i class="bi bi-arrow-up" aria-hidden="true"></i>
                        <span>Back to the Beginning</span>
                    </a>
                </div>
            </div>

            <footer class="site-footer">
                <p>Made with Love <svg class="site-footer__heart" aria-hidden="true"><use href="#i-heart"/></svg><span class="visually-hidden">♡</span></p>
                <small>for Novi · {{ now()->year }}</small>
            </footer>
        </section>
    </main>

    {{-- ===================== BACKGROUND MUSIC ===================== --}}
    <audio id="bg-music" src="{{ asset('birthday/music/romantic.mp3') }}" preload="none" loop></audio>

    <button type="button" class="music-toggle" data-music-toggle aria-pressed="false" aria-label="Putar musik" title="Putar / jeda musik">
        <span class="music-toggle__disc" aria-hidden="true"></span>
        <i class="bi bi-play-fill music-toggle__icon" data-music-icon aria-hidden="true"></i>
    </button>

    <div class="love-toast" data-toast role="status" aria-live="polite"></div>

    {{-- ===================== LIGHTBOX GALERI ===================== --}}
    <div class="modal fade modal-lightbox" id="lightboxModal" tabindex="-1" aria-label="Foto kenangan" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <button type="button" class="lightbox__close" data-bs-dismiss="modal" aria-label="Tutup">
                    <i class="bi bi-x-lg" aria-hidden="true"></i>
                </button>

                <figure class="lightbox__figure" data-lightbox-stage>
                    <img src="{{ asset('birthday/images/' . $memories[0]['file']) }}" alt="" class="lightbox__image" loading="lazy" decoding="async" data-lightbox-image data-fallback>
                    <figcaption class="lightbox__caption">
                        <span data-lightbox-caption></span>
                        <small class="lightbox__counter" data-lightbox-counter></small>
                    </figcaption>
                </figure>

                <button type="button" class="lightbox__nav lightbox__nav--prev" data-lightbox-prev aria-label="Foto sebelumnya">
                    <i class="bi bi-chevron-left" aria-hidden="true"></i>
                </button>
                <button type="button" class="lightbox__nav lightbox__nav--next" data-lightbox-next aria-label="Foto berikutnya">
                    <i class="bi bi-chevron-right" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- ===================== HASIL GACHA HADIAH ===================== --}}
    <div class="modal fade modal-surprise" id="giftModal" tabindex="-1" aria-labelledby="gift-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content surprise-card">
                <svg class="surprise-card__floral surprise-card__floral--tl" aria-hidden="true"><use href="#i-spray"/></svg>
                <svg class="surprise-card__floral surprise-card__floral--br floral-spray--mirror-xy" aria-hidden="true"><use href="#i-spray"/></svg>

                <button type="button" class="surprise-card__close" data-bs-dismiss="modal" aria-label="Tutup">
                    <i class="bi bi-x-lg" aria-hidden="true"></i>
                </button>

                <div class="surprise-card__body">
                    <p class="eyebrow mb-2">Selamat, kamu dapat</p>
                    <div class="gift-reveal__emoji" data-gift-modal-emoji aria-hidden="true"></div>
                    <h2 id="gift-modal-title" class="surprise-card__title" data-gift-modal-label></h2>
                    <p data-gift-modal-note></p>
                    <p class="gift-reveal__footnote" data-gift-modal-footnote></p>

                    <button type="button" class="btn-love" data-bs-dismiss="modal">
                        <span>Yay, Thank You</span>
                        <svg class="btn-love__heart" aria-hidden="true"><use href="#i-heart"/></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script type="application/json" id="gift-data">@json($giftData)</script>

    {{-- ===================== PESAN KEJUTAN AMPLOP ===================== --}}
    <div class="modal fade modal-surprise" id="surpriseModal" tabindex="-1" aria-labelledby="surprise-message-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content surprise-card">
                <svg class="surprise-card__floral surprise-card__floral--tl" aria-hidden="true"><use href="#i-spray"/></svg>
                <svg class="surprise-card__floral surprise-card__floral--br floral-spray--mirror-xy" aria-hidden="true"><use href="#i-spray"/></svg>

                <button type="button" class="surprise-card__close" data-bs-dismiss="modal" aria-label="Tutup">
                    <i class="bi bi-x-lg" aria-hidden="true"></i>
                </button>

                <div class="surprise-card__body">
                    <h2 id="surprise-message-title" class="surprise-card__title">Happy Birthday, Novi! ❤️</h2>
                    <p>Semoga kebahagiaan selalu menemukan jalan menuju hatimu.</p>
                    <p>Semoga kamu selalu sehat, bahagia, dikelilingi orang-orang baik, dan mendapatkan semua cinta yang pantas kamu terima.</p>
                    <p class="surprise-card__closing">You deserve the whole universe. ❤️</p>

                    <button type="button" class="btn-love" data-bs-dismiss="modal">
                        <span>Thank You</span>
                        <svg class="btn-love__heart" aria-hidden="true"><use href="#i-heart"/></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js" defer></script>
    <script src="{{ asset('birthday/js/birthday.js') }}" defer></script>
</body>
</html>
