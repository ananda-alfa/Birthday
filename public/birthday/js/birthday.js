/**
 * Happy Birthday, Novi ♡
 * ------------------------------------------------------------------
 * Vanilla JavaScript for the birthday microsite. Every feature lives
 * in its own small init function and is wired together at the bottom.
 */
(() => {
    'use strict';

    /* ---------- Settings & helpers ---------- */

    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const isSmallScreen = window.matchMedia('(max-width: 767.98px)').matches;

    const PALETTE = ['#FCE4EC', '#F8BBD0', '#EFA3BD', '#C65F85', '#FFFFFF', '#F4C989'];
    const FLOATER_COLORS = ['#EFA3BD', '#F8BBD0', '#C65F85', '#F4B5CB'];
    const HEART_PATH = 'M167 72c19,-38 37,-56 75,-56 42,0 76,33 76,75 0,76 -76,151 -151,227 -76,-76 -151,-151 -151,-227 0,-42 33,-75 75,-75 38,0 57,18 76,56z';

    const $ = (selector, root = document) => root.querySelector(selector);
    const $$ = (selector, root = document) => Array.from(root.querySelectorAll(selector));
    const random = (min, max) => Math.random() * (max - min) + min;
    const pick = (list) => list[Math.floor(Math.random() * list.length)];
    const wait = (ms) => new Promise((resolve) => setTimeout(resolve, ms));
    const svgIcon = (id) => `<svg aria-hidden="true"><use href="${id}"></use></svg>`;

    /* Soft pink placeholder used when a photo file is missing. */
    const PLACEHOLDER_IMAGE = 'data:image/svg+xml;charset=utf-8,' + encodeURIComponent(
        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 500">' +
        '<defs><linearGradient id="g" x1="0" y1="0" x2="1" y2="1">' +
        '<stop offset="0" stop-color="#FCE4EC"/><stop offset="1" stop-color="#EFA3BD"/></linearGradient></defs>' +
        '<rect width="400" height="500" fill="url(#g)"/>' +
        '<path transform="translate(140 190) scale(5)" fill="#fff" fill-opacity=".85" ' +
        'd="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>' +
        '</svg>'
    );

    const getModal = (element) => (
        element && window.bootstrap && window.bootstrap.Modal
            ? window.bootstrap.Modal.getOrCreateInstance(element)
            : null
    );

    /* ---------- Toast ---------- */

    const showToast = (() => {
        const toast = $('[data-toast]');
        let timer;

        return (message) => {
            if (!toast) return;
            toast.textContent = message;
            toast.classList.add('is-visible');
            clearTimeout(timer);
            timer = setTimeout(() => toast.classList.remove('is-visible'), 3400);
        };
    })();

    /* ---------- Confetti ---------- */

    /**
     * Fires a pink confetti burst with hearts.
     * Returns false when confetti is unavailable (library blocked or reduced motion).
     */
    const celebrate = (() => {
        const canvas = $('#confetti-canvas');
        const library = window.confetti;

        if (!canvas || typeof library !== 'function' || reducedMotion) {
            return () => false;
        }

        const fire = library.create(canvas, { resize: true, useWorker: false });
        const heart = typeof library.shapeFromPath === 'function'
            ? library.shapeFromPath({ path: HEART_PATH })
            : null;

        return ({ intensity = 1 } = {}) => {
            const base = { colors: PALETTE, ticks: 240, gravity: .9, disableForReducedMotion: true };
            const count = (amount) => Math.round(amount * intensity * (isSmallScreen ? .7 : 1));

            fire({ ...base, particleCount: count(90), spread: 80, startVelocity: 45, origin: { x: .5, y: .62 }, shapes: ['circle', 'square'] });

            if (heart) {
                fire({ ...base, particleCount: count(28), spread: 100, startVelocity: 38, scalar: 1.8, origin: { x: .5, y: .6 }, shapes: [heart] });
            }

            setTimeout(() => {
                fire({ ...base, particleCount: count(45), angle: 60, spread: 60, origin: { x: 0, y: .78 } });
                fire({ ...base, particleCount: count(45), angle: 120, spread: 60, origin: { x: 1, y: .78 } });
            }, 260);

            return true;
        };
    })();

    /* ---------- Broken image fallback ---------- */

    function initImageFallbacks() {
        $$('img[data-fallback]').forEach((image) => {
            const useFallback = () => {
                if (image.src !== PLACEHOLDER_IMAGE) image.src = PLACEHOLDER_IMAGE;
            };

            image.addEventListener('error', useFallback);

            // An eager image may already have failed before this script ran.
            if (image.loading !== 'lazy' && image.getAttribute('src') && image.complete && image.naturalWidth === 0) {
                useFallback();
            }
        });
    }

    /* ---------- Floating hearts & petals ---------- */

    function initAmbient() {
        const layer = $('[data-ambient]');
        if (!layer || reducedMotion) return;

        const icons = ['#i-heart', '#i-heart', '#i-petal', '#i-flower'];
        const total = isSmallScreen ? 10 : 18;
        const fragment = document.createDocumentFragment();

        for (let index = 0; index < total; index += 1) {
            const duration = random(16, 28);
            const floater = document.createElement('span');

            floater.className = 'floater';
            floater.style.cssText = [
                `--x: ${random(0, 100).toFixed(1)}%`,
                `--size: ${random(12, 26).toFixed(0)}px`,
                `--dur: ${duration.toFixed(1)}s`,
                `--delay: ${(-random(0, duration)).toFixed(1)}s`,
                `--drift: ${random(-60, 60).toFixed(0)}px`,
                `--spin: ${random(-200, 200).toFixed(0)}deg`,
                `--o: ${random(.3, .6).toFixed(2)}`,
                `--c: ${pick(FLOATER_COLORS)}`,
            ].join(';');
            floater.innerHTML = svgIcon(pick(icons));
            fragment.appendChild(floater);
        }

        layer.appendChild(fragment);
    }

    /* ---------- Sparkles ---------- */

    function initSparkles() {
        if (reducedMotion) return;

        $$('[data-sparkles]').forEach((field) => {
            const total = Math.round(Number(field.dataset.sparkles || 10) * (isSmallScreen ? .6 : 1));
            const color = field.dataset.sparkleColor || '#FFFFFF';
            const fragment = document.createDocumentFragment();

            for (let index = 0; index < total; index += 1) {
                const sparkle = document.createElement('span');

                sparkle.className = 'sparkle';
                sparkle.style.cssText = [
                    `--x: ${random(2, 98).toFixed(1)}%`,
                    `--y: ${random(2, 98).toFixed(1)}%`,
                    `--s: ${random(6, 16).toFixed(0)}px`,
                    `--dur: ${random(2.4, 5).toFixed(1)}s`,
                    `--delay: ${(-random(0, 5)).toFixed(1)}s`,
                    `--c: ${color}`,
                ].join(';');
                sparkle.innerHTML = svgIcon('#i-sparkle');
                fragment.appendChild(sparkle);
            }

            field.appendChild(fragment);
        });
    }

    /* ---------- Fade-in on scroll ---------- */

    function initReveal() {
        const items = $$('.reveal');

        if (reducedMotion || !('IntersectionObserver' in window)) {
            items.forEach((item) => item.classList.add('is-visible'));
            return;
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            });
        }, { threshold: .15, rootMargin: '0px 0px -6% 0px' });

        items.forEach((item) => observer.observe(item));
    }

    /* ---------- Background music ---------- */

    function initMusic() {
        const audio = $('#bg-music');
        const button = $('[data-music-toggle]');

        if (!audio || !button) {
            return { play: () => Promise.resolve(false) };
        }

        const icon = $('[data-music-icon]', button);
        audio.volume = .5;

        const render = (isPlaying) => {
            button.classList.toggle('is-playing', isPlaying);
            button.setAttribute('aria-pressed', String(isPlaying));
            button.setAttribute('aria-label', isPlaying ? 'Jeda musik' : 'Putar musik');
            icon.className = `bi ${isPlaying ? 'bi-pause-fill' : 'bi-play-fill'} music-toggle__icon`;
        };

        const play = async () => {
            try {
                await audio.play();
                return true;
            } catch (error) {
                render(false);
                if (error.name === 'NotAllowedError') {
                    showToast('Ketuk tombol musik di pojok kanan bawah untuk memutar lagu ♡');
                } else if (error.name !== 'AbortError') {
                    showToast('Musiknya belum bisa diputar saat ini.');
                }
                return false;
            }
        };

        audio.addEventListener('playing', () => render(true));
        audio.addEventListener('pause', () => render(false));
        button.addEventListener('click', () => (audio.paused ? play() : audio.pause()));

        return { play };
    }

    /* ---------- Opening button ---------- */

    function initOpening(music) {
        // play() must start inside the click handler so browsers allow audio.
        // Moving to the next page is handled by initStory (data-story-goto).
        $$('[data-open-surprise]').forEach((button) => {
            button.addEventListener('click', () => music.play());
        });
    }

    /* ---------- Story mode: one page at a time ---------- */

    /**
     * Turns the long page into click-through pages: Back / Next buttons,
     * side dots, arrow keys and swipe. Returns false when there are no
     * pages, so the regular scrolling page keeps working.
     */
    function initStory() {
        const root = document.documentElement;
        const slides = $$('[data-slide]');
        const nav = $('[data-story-nav]');

        if (slides.length < 2 || !nav) {
            root.classList.remove('story-mode');
            return false;
        }

        root.classList.add('story-mode');

        const prevButton = $('[data-story-prev]', nav);
        const nextButton = $('[data-story-next]', nav);
        const nextLabel = $('[data-story-next-label]', nav);
        const counter = $('[data-story-counter]', nav);
        const progress = $('[data-story-progress]');
        const dots = $$('[data-dot-link]');
        const scrollHint = $('[data-scroll-hint]');
        const SWITCH_LOCK_MS = reducedMotion ? 0 : 650;
        const LEAVE_MS = reducedMotion ? 0 : 900;
        const REVEAL_DELAY_MS = reducedMotion ? 0 : 250;
        let current = -1;
        let lockedUntil = 0;

        const setReveal = (slide, visible) => {
            $$('.reveal', slide).forEach((item) => item.classList.toggle('is-visible', visible));
        };

        // Show a small "more below" arrow while the open page still has content under the fold.
        const updateScrollHint = () => {
            if (!scrollHint) return;
            const slide = slides[current];
            const remaining = slide.scrollHeight - slide.clientHeight - slide.scrollTop;
            scrollHint.classList.toggle('is-visible', remaining > 40);
        };

        const updateControls = () => {
            const slide = slides[current];

            nav.classList.toggle('is-hidden', current === 0);
            nextButton.hidden = current === slides.length - 1;
            nextLabel.textContent = slide.dataset.nextLabel || 'Next';
            counter.textContent = `${current + 1} / ${slides.length}`;
            if (progress) progress.style.width = `${(current / (slides.length - 1)) * 100}%`;

            dots.forEach((dot) => {
                const isActive = dot.hash === `#${slide.id}`;
                dot.classList.toggle('is-active', isActive);
                if (isActive) dot.setAttribute('aria-current', 'step');
                else dot.removeAttribute('aria-current');
            });
        };

        const show = (index) => {
            if (index < 0 || index >= slides.length || index === current) return;

            const now = Date.now();
            if (now < lockedUntil) return;
            lockedUntil = now + SWITCH_LOCK_MS;

            const leaving = slides[current];
            const entering = slides[index];
            const focusWasInside = leaving && leaving.contains(document.activeElement);
            current = index;

            if (leaving) {
                leaving.classList.remove('is-active');
                leaving.classList.add('is-leaving');
                setTimeout(() => {
                    leaving.classList.remove('is-leaving');
                    // reset animations so they play again next time this page opens
                    if (leaving !== slides[current]) setReveal(leaving, false);
                }, LEAVE_MS);
            }

            entering.classList.remove('is-leaving');
            entering.scrollTop = 0;
            entering.classList.add('is-active');
            if (focusWasInside) entering.focus({ preventScroll: true });

            setTimeout(() => {
                if (entering === slides[current]) setReveal(entering, true);
            }, REVEAL_DELAY_MS);

            updateControls();
            updateScrollHint();
        };

        const next = () => show(current + 1);
        const prev = () => show(current - 1);
        const isModalOpen = () => document.body.classList.contains('modal-open');

        nextButton.addEventListener('click', next);
        prevButton.addEventListener('click', prev);

        slides.forEach((slide) => {
            slide.addEventListener('scroll', () => {
                if (slide === slides[current]) updateScrollHint();
            }, { passive: true });
        });
        window.addEventListener('resize', updateScrollHint);

        if (scrollHint) {
            scrollHint.addEventListener('click', () => {
                const slide = slides[current];
                slide.scrollBy({ top: slide.clientHeight * .7, behavior: reducedMotion ? 'auto' : 'smooth' });
            });
        }

        $$('[data-story-goto]').forEach((trigger) => {
            trigger.addEventListener('click', (event) => {
                const index = slides.findIndex((slide) => slide.id === trigger.dataset.storyGoto);
                if (index === -1) return;
                event.preventDefault();
                show(index);
            });
        });

        document.addEventListener('keydown', (event) => {
            if (isModalOpen() || event.altKey || event.ctrlKey || event.metaKey) return;
            if (event.key === 'ArrowRight') next();
            if (event.key === 'ArrowLeft') prev();
        });

        // Swipe left / right anywhere on the page (except inside the photo strip).
        let touchStart = null;

        document.addEventListener('touchstart', (event) => {
            const ignore = isModalOpen() || event.touches.length > 1 || event.target.closest('[data-swipe-ignore]');
            touchStart = ignore ? null : { x: event.touches[0].clientX, y: event.touches[0].clientY };
        }, { passive: true });

        document.addEventListener('touchend', (event) => {
            if (!touchStart) return;
            const deltaX = event.changedTouches[0].clientX - touchStart.x;
            const deltaY = event.changedTouches[0].clientY - touchStart.y;
            touchStart = null;

            if (Math.abs(deltaX) < 60 || Math.abs(deltaX) < Math.abs(deltaY) * 1.5) return;
            if (deltaX < 0) next();
            else prev();
        }, { passive: true });

        window.scrollTo(0, 0);
        show(0);
        return true;
    }

    /* ---------- Gallery lightbox ---------- */

    function initGallery() {
        const items = $$('[data-lightbox-item]');
        const modalElement = $('#lightboxModal');
        const modal = getModal(modalElement);
        if (!items.length || !modalElement) return;

        const image = $('[data-lightbox-image]', modalElement);
        const caption = $('[data-lightbox-caption]', modalElement);
        const counter = $('[data-lightbox-counter]', modalElement);
        const stage = $('[data-lightbox-stage]', modalElement);
        let current = 0;

        const render = () => {
            const item = items[current];
            const thumbnail = $('img', item);

            image.src = thumbnail && thumbnail.currentSrc ? thumbnail.currentSrc : item.dataset.src;
            image.alt = thumbnail ? thumbnail.alt : '';
            caption.textContent = item.dataset.caption || '';
            counter.textContent = `${current + 1} / ${items.length}`;
        };

        const go = async (step) => {
            current = (current + step + items.length) % items.length;
            if (!reducedMotion) {
                image.classList.add('is-changing');
                await wait(200);
            }
            render();
            image.classList.remove('is-changing');
        };

        items.forEach((item, index) => {
            item.addEventListener('click', () => {
                current = index;
                render();
                if (modal) modal.show();
                else window.open(item.dataset.src, '_blank', 'noopener');
            });
        });

        $('[data-lightbox-prev]', modalElement).addEventListener('click', () => go(-1));
        $('[data-lightbox-next]', modalElement).addEventListener('click', () => go(1));

        modalElement.addEventListener('keydown', (event) => {
            if (event.key === 'ArrowLeft') go(-1);
            if (event.key === 'ArrowRight') go(1);
        });

        // Swipe left / right on touch screens.
        let touchStartX = null;
        stage.addEventListener('touchstart', (event) => {
            touchStartX = event.changedTouches[0].clientX;
        }, { passive: true });
        stage.addEventListener('touchend', (event) => {
            if (touchStartX === null) return;
            const distance = event.changedTouches[0].clientX - touchStartX;
            if (Math.abs(distance) > 50) go(distance < 0 ? 1 : -1);
            touchStartX = null;
        });
    }

    /* ---------- Gallery photo strip (story mode) ---------- */

    function initGalleryTrack() {
        const track = $('[data-gallery-track]');
        const prevButton = $('[data-gallery-prev]');
        const nextButton = $('[data-gallery-next]');
        if (!track || !prevButton || !nextButton) return;

        const behavior = reducedMotion ? 'auto' : 'smooth';
        const cardWidth = () => {
            const card = track.firstElementChild;
            return card ? card.getBoundingClientRect().width : track.clientWidth * .8;
        };
        const maxScroll = () => track.scrollWidth - track.clientWidth;

        const updateButtons = () => {
            prevButton.disabled = track.scrollLeft <= 4;
            nextButton.disabled = track.scrollLeft >= maxScroll() - 4;
        };

        prevButton.addEventListener('click', () => track.scrollBy({ left: -cardWidth(), behavior }));
        nextButton.addEventListener('click', () => track.scrollBy({ left: cardWidth(), behavior }));

        // A normal mouse wheel scrolls the strip sideways.
        track.addEventListener('wheel', (event) => {
            if (Math.abs(event.deltaY) <= Math.abs(event.deltaX)) return;
            const atStart = track.scrollLeft <= 0 && event.deltaY < 0;
            const atEnd = track.scrollLeft >= maxScroll() - 1 && event.deltaY > 0;
            if (atStart || atEnd) return;
            event.preventDefault();
            track.scrollLeft += event.deltaY;
        }, { passive: false });

        track.addEventListener('scroll', updateButtons, { passive: true });
        window.addEventListener('resize', updateButtons);
        updateButtons();
    }

    /* ---------- Birthday cake ---------- */

    function initCake() {
        const stage = $('[data-cake]');
        const button = $('[data-wish-button]');
        const message = $('[data-wish-message]');
        if (!stage || !button || !message) return;

        const label = $('[data-wish-label]', button);
        const icon = $('[data-wish-icon]', button);
        let state = 'lit'; // lit → blowing → out

        const setButton = (text, iconClass) => {
            label.textContent = text;
            icon.className = `bi ${iconClass}`;
        };

        const blowOut = async () => {
            state = 'blowing';
            button.disabled = true;
            stage.classList.add('is-blowing');
            await wait(reducedMotion ? 0 : 750);

            stage.classList.remove('is-blowing');
            stage.classList.add('is-out');
            await wait(reducedMotion ? 0 : 350);

            celebrate();
            message.textContent = message.dataset.text;
            message.classList.add('is-shown');
            setButton('Light the Candles Again', 'bi-arrow-repeat');
            button.disabled = false;
            state = 'out';
        };

        const relight = () => {
            stage.classList.remove('is-out');
            message.classList.remove('is-shown');
            setButton('Make a Wish', 'bi-stars');
            state = 'lit';
        };

        button.addEventListener('click', () => {
            if (state === 'lit') blowOut();
            else if (state === 'out') relight();
        });
    }

    /* ---------- Love envelope ---------- */

    function initEnvelope() {
        const envelope = $('[data-envelope]');
        const modalElement = $('#surpriseModal');
        if (!envelope || !modalElement) return;

        const modal = getModal(modalElement);
        const hint = $('[data-envelope-hint]');
        const resetButton = $('[data-envelope-reset]');
        let state = 'closed'; // closed → opening → open

        const showMessage = () => {
            if (modal) modal.show();
        };

        envelope.addEventListener('click', async () => {
            if (state === 'opening') return;
            if (state === 'open') {
                showMessage();
                return;
            }

            state = 'opening';
            envelope.classList.add('is-open');
            envelope.setAttribute('aria-expanded', 'true');
            envelope.setAttribute('aria-label', 'Baca lagi pesan kejutan');
            await wait(reducedMotion ? 150 : 1700);

            state = 'open';
            celebrate({ intensity: 1.2 });
            showMessage();
            hint.textContent = 'Tap the envelope to read it again ♡';
            resetButton.hidden = false;
        });

        resetButton.addEventListener('click', () => {
            envelope.classList.remove('is-open');
            envelope.setAttribute('aria-expanded', 'false');
            envelope.setAttribute('aria-label', 'Buka amplop kejutan');
            hint.textContent = hint.dataset.default;
            resetButton.hidden = true;
            state = 'closed';
        });
    }

    /* ---------- Gift gacha ---------- */

    /**
     * Novi shuffles the gift boxes, then picks one. The server decides what is
     * inside every box and locks the first result, so the pick cannot be redone.
     */
    function initGacha() {
        const machine = $('[data-gacha]');
        const dataElement = $('#gift-data');
        if (!machine || !dataElement) return;

        const { options, choice, url } = JSON.parse(dataElement.textContent);
        const giftByKey = new Map(options.map((gift) => [gift.key, gift]));
        const boxes = $$('[data-gift-box]', machine);
        const shuffleButton = $('[data-gacha-shuffle]');
        const shuffleLabel = $('[data-gacha-shuffle-label]');
        const instruction = $('[data-gacha-instruction]');
        const summary = $('[data-gift-summary]');
        const summaryLabel = $('[data-gift-summary-label]');
        const showAgainButton = $('[data-gift-show]');
        const modalElement = $('#giftModal');
        const modal = getModal(modalElement);
        let state = 'idle'; // idle → shuffling → picking → opening → done

        boxes.forEach((box, index) => { box.style.order = String(index); });

        const fillBox = (box, gift) => {
            $('[data-gift-emoji]', box).textContent = gift.emoji;
            $('[data-gift-label]', box).textContent = gift.label;
            box.setAttribute('aria-label', `Kotak ${Number(box.dataset.giftBox) + 1}: ${gift.label}`);
        };

        const fillModal = (gift, saved) => {
            $('[data-gift-modal-emoji]', modalElement).textContent = gift.emoji;
            $('[data-gift-modal-label]', modalElement).textContent = gift.label;
            $('[data-gift-modal-note]', modalElement).textContent = gift.note;
            $('[data-gift-modal-footnote]', modalElement).textContent = saved
                ? 'Pilihanmu sudah tercatat. Nanti aku siapkan hadiahnya untukmu ♡'
                : 'Screenshot halaman ini dan kirim ke aku ya ♡';
        };

        // Final, locked state (also used when the page is reopened after picking).
        const finish = (result) => {
            const gift = giftByKey.get(result.gift);

            boxes.forEach((box, index) => {
                fillBox(box, giftByKey.get(result.arrangement[index]));
                box.disabled = true;
                box.classList.remove('is-picked');
                box.classList.add('is-open');
                box.classList.toggle('is-chosen', index === result.box);
                box.classList.toggle('is-other', index !== result.box);
            });

            machine.classList.remove('is-ready', 'is-shuffling');
            shuffleButton.hidden = true;
            summaryLabel.textContent = `${gift.emoji} ${gift.label}`;
            summary.hidden = false;
            instruction.textContent = 'Kamu sudah memilih hadiahmu. Ini dia isi semua kotaknya ♡';
            fillModal(gift, result.saved !== false);
            state = 'done';
        };

        // FLIP animation: swap the visual order of two boxes and glide them into place.
        const swapBoxes = (first, second) => {
            const before = boxes.map((box) => box.getBoundingClientRect());
            [first.style.order, second.style.order] = [second.style.order, first.style.order];

            boxes.forEach((box, index) => {
                const after = box.getBoundingClientRect();
                const deltaX = before[index].left - after.left;
                const deltaY = before[index].top - after.top;
                if (!deltaX && !deltaY) return;

                box.style.transition = 'none';
                box.style.transform = `translate(${deltaX}px, ${deltaY}px)`;
                box.getBoundingClientRect(); // commit the starting position
                box.style.transition = '';
                box.style.transform = '';
            });
        };

        const shuffle = async () => {
            if (state !== 'idle' && state !== 'picking') return;

            state = 'shuffling';
            shuffleButton.disabled = true;
            boxes.forEach((box) => { box.disabled = true; });
            machine.classList.remove('is-ready');
            machine.classList.add('is-shuffling');
            instruction.textContent = 'Mengacak hadiah...';

            const rounds = reducedMotion ? 1 : 10;
            for (let round = 0; round < rounds; round += 1) {
                const first = pick(boxes);
                let second = pick(boxes);
                while (second === first) second = pick(boxes);
                swapBoxes(first, second);
                await wait(reducedMotion ? 0 : 280);
            }

            machine.classList.remove('is-shuffling');
            machine.classList.add('is-ready');
            boxes.forEach((box) => { box.disabled = false; });
            shuffleButton.disabled = false;
            shuffleLabel.textContent = 'Acak Lagi';
            instruction.textContent = 'Sekarang pilih satu kotak ♡';
            state = 'picking';
        };

        const localDraw = (box) => {
            const arrangement = options.map((gift) => gift.key);
            for (let index = arrangement.length - 1; index > 0; index -= 1) {
                const swapWith = Math.floor(Math.random() * (index + 1));
                [arrangement[index], arrangement[swapWith]] = [arrangement[swapWith], arrangement[index]];
            }
            return { box, gift: arrangement[box], arrangement, saved: false };
        };

        const requestPick = async (box) => {
            try {
                const token = $('meta[name="csrf-token"]');
                const response = await fetch(url, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json',
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': token ? token.content : '',
                    },
                    body: JSON.stringify({ box }),
                });
                if (!response.ok) throw new Error(`HTTP ${response.status}`);

                const result = await response.json();
                const valid = giftByKey.has(result.gift)
                    && Array.isArray(result.arrangement)
                    && result.arrangement.length === boxes.length;
                return valid ? { ...result, saved: true } : localDraw(box);
            } catch {
                // Server unreachable (e.g. static hosting): still let her open a gift.
                return localDraw(box);
            }
        };

        const openBox = async (box) => {
            if (state !== 'picking') return;

            state = 'opening';
            boxes.forEach((item) => { item.disabled = true; });
            shuffleButton.hidden = true;
            machine.classList.remove('is-ready');
            box.classList.add('is-picked');
            instruction.textContent = 'Membuka kotakmu...';

            const [result] = await Promise.all([
                requestPick(Number(box.dataset.giftBox)),
                wait(reducedMotion ? 0 : 1400),
            ]);

            // The chosen box opens first, the others follow a moment later.
            const chosen = boxes[result.box];
            box.classList.remove('is-picked');
            fillBox(chosen, giftByKey.get(result.gift));
            chosen.classList.add('is-open', 'is-chosen');
            celebrate({ intensity: 1.4 });
            await wait(reducedMotion ? 0 : 1100);

            finish(result);
            await wait(reducedMotion ? 0 : 500);
            if (modal) modal.show();
        };

        shuffleButton.addEventListener('click', shuffle);
        boxes.forEach((box) => box.addEventListener('click', () => openBox(box)));
        showAgainButton.addEventListener('click', () => { if (modal) modal.show(); });

        if (choice && giftByKey.has(choice.gift)) finish(choice);
    }

    /* ---------- Finale ---------- */

    function initFinale() {
        $$('[data-celebrate]').forEach((button) => {
            button.addEventListener('click', () => {
                const fired = celebrate({ intensity: 1.3 });
                if (!fired) showToast('Sending all my love to you, Novi ♡');
            });
        });
    }

    /* ---------- Light parallax: hero flowers follow the mouse (desktop only) ---------- */

    function initParallax() {
        if (reducedMotion || !window.matchMedia('(pointer: fine)').matches) return;

        const hero = $('#hero');
        const layers = hero ? $$('[data-parallax]', hero) : [];
        if (!layers.length) return;

        let frame = null;

        hero.addEventListener('pointermove', (event) => {
            if (frame) return;
            frame = window.requestAnimationFrame(() => {
                const x = event.clientX / window.innerWidth - .5;
                const y = event.clientY / window.innerHeight - .5;
                layers.forEach((layer) => {
                    const depth = Number(layer.dataset.parallax) * 120;
                    // `translate` (not `transform`) so mirrored layers still move in screen space.
                    layer.style.translate = `${(x * depth).toFixed(1)}px ${(y * depth).toFixed(1)}px`;
                });
                frame = null;
            });
        });
    }

    /* ---------- Start ---------- */

    initImageFallbacks();
    initAmbient();
    initSparkles();
    if (!initStory()) initReveal();
    initOpening(initMusic());
    initGallery();
    initGalleryTrack();
    initCake();
    initEnvelope();
    initGacha();
    initFinale();
    initParallax();
})();
