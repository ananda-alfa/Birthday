# Happy Birthday, Novi ♡ — Panduan

Website ucapan ulang tahun (Laravel 12 + Blade + Bootstrap 5 + Vanilla JS).

## Cara kerjanya

Halaman tampil per layar, seperti membuka buku cerita. Ada 8 halaman:

1. Opening → 2. For You → 3. Surat → 4. Galeri → 5. Kue → 6. Amplop → 7. **Gacha Hadiah** → 8. Penutup

Cara pindah halaman:

- tombol **Next / Back** di bawah (label tombol Next berganti sesuai halaman, misalnya "Read My Letter", "Make a Wish")
- swipe kiri/kanan di HP
- tombol panah ← → di keyboard
- titik navigasi di sisi kanan (khusus desktop)

Halaman yang lebih tinggi dari layar (misalnya surat) bisa digulir di dalam halamannya sendiri. Panah kecil ⌄ muncul sebagai tanda masih ada isi di bawah.

## Gacha hadiah

Novi menekan **Acak Hadiahnya**, kotak-kotak berputar tukar posisi, lalu ia memilih satu kotak.
Isi kotak diundi oleh **server**, jadi tidak bisa diintip atau dicurangi dari browser.
Hasil pertama **dikunci**: dibuka ulang, di-refresh, atau dibuka dari HP lain, hasilnya tetap sama.

```bash
php artisan birthday:gift          # lihat hadiah yang dipilih Novi (dan isi semua kotak)
php artisan birthday:reset-gift    # hapus hasil supaya gacha bisa dimainkan lagi
```

> **Penting:** kalau kamu mencoba gacha-nya sendiri, jalankan `php artisan birthday:reset-gift`
> **sebelum** link dikirim ke Novi. Kalau tidak, Novi akan melihat hasil uji cobamu.

Hasil disimpan di `storage/app/private/birthday/novi-gift.json` dan juga dicatat di `storage/logs/laravel.log`.

**Mengubah daftar hadiah:** edit `config/birthday.php` (label, emoji, dan pesan manis per hadiah).
Jumlah kotak otomatis mengikuti jumlah hadiah.

## Struktur file

```
routes/web.php                              ← /birthday/novi (halaman) + POST /birthday/novi/gift (undian)
routes/console.php                          ← perintah birthday:gift & birthday:reset-gift
config/birthday.php                         ← daftar hadiah gacha
app/Support/BirthdayGift.php                ← logika undian & penyimpanan hasil
app/Http/Controllers/BirthdayGiftController.php
resources/views/birthday/novi.blade.php     ← halaman (HTML)
public/birthday/
    css/style.css                           ← seluruh tampilan & animasi
    js/birthday.js                          ← seluruh interaksi
    music/romantic.mp3                      ← musik latar (contoh: music box "Happy Birthday")
    images/novi-1.jpg … novi-6.jpg          ← foto galeri (masih placeholder)
preview/                                    ← screenshot desain
```

## Menjalankan

```bash
cd D:\birthday-novi
php artisan serve
```

Buka **http://127.0.0.1:8000/birthday/novi**

Supaya bisa dibuka dari HP di jaringan Wi-Fi yang sama:

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

lalu buka `http://<IP-laptop>:8000/birthday/novi` di HP.

## Mengganti foto

1. Siapkan 6 foto, sebaiknya **portrait 4:5** (misalnya 1200×1500 px), ukurannya di bawah ~400 KB per file.
2. Timpa file `public/birthday/images/novi-1.jpg` sampai `novi-6.jpg` dengan nama yang sama.
3. Ubah caption di bagian atas `resources/views/birthday/novi.blade.php` (array `$memories`).

Foto yang bukan 4:5 tetap rapi karena otomatis dipotong di tengah.
Kalau sebuah file hilang, halaman menampilkan placeholder pink, bukan gambar rusak.

## Mengganti musik

Timpa `public/birthday/music/romantic.mp3` dengan lagu pilihanmu (nama file tetap `romantic.mp3`).
Musik mulai diputar saat tombol **Open Your Surprise** ditekan atau saat tombol musik di pojok kanan bawah ditekan.
Browser memang melarang musik berputar otomatis sebelum ada interaksi.

## Mengubah teks

Semua teks ada di `novi.blade.php`, dikelompokkan per section (lihat komentar `SECTION 1` … `SECTION 7`).
Label tombol Next per halaman ada di atribut `data-next-label` pada tiap `<section>`.

## Online lewat GitHub Pages (gratis)

Link: **https://ananda-alfa.github.io/Birthday/**

Folder `docs/` berisi versi HTML statis yang dibaca GitHub Pages. Di versi ini gacha diundi di browser Novi,
dikunci di browser itu (refresh tidak mengubah hasil), dan **tidak tercatat di server**. Novi diminta mengirim screenshot.

Aktifkan sekali saja:

1. Repo harus **Public** (Pages untuk repo private butuh akun GitHub berbayar):
   Settings → General → Danger Zone → Change visibility → Public.
2. Settings → Pages → *Build and deployment* → Source: **Deploy from a branch** →
   Branch: **main**, folder: **/docs** → Save.
3. Tunggu 1–3 menit, lalu buka linknya.

**Setiap kali mengubah sesuatu** (foto, musik, teks, hadiah), build ulang lalu push:

```bash
php artisan birthday:build-static
git add -A
git commit -m "Update website"
git push
```

## Deploy ke hosting

- Butuh hosting yang menjalankan PHP/Laravel, karena gacha memakai server. Jalankan `php artisan migrate` (tabel session) dan pastikan folder `storage/` bisa ditulisi.
- Set `APP_URL` di `.env` ke domain asli supaya `asset()` dan preview link (og:image) benar.
- Halaman diberi `noindex` supaya tidak muncul di Google.
- Kalau server tidak bisa dihubungi, gacha tetap bisa dimainkan (diundi di browser), tapi hasilnya **tidak tercatat**. Novi akan diminta mengirim screenshot.
