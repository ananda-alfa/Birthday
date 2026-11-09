<?php

use App\Support\BirthdayGift;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('birthday:gift', function () {
    $choice = BirthdayGift::current();

    if (! $choice) {
        $this->info('Novi belum memilih hadiah.');

        return;
    }

    $this->info('Hadiah pilihan Novi: '.BirthdayGift::label($choice['gift']));
    $this->line('Dipilih pada: '.$choice['picked_at']);
    $this->line('Isi kotak 1-'.count($choice['arrangement']).': '.implode(', ', array_map(
        fn (string $key) => BirthdayGift::label($key),
        $choice['arrangement'],
    )));
})->purpose('Lihat hadiah yang dipilih Novi di gacha');

Artisan::command(
    'birthday:build-static
        {--url=https://ananda-alfa.github.io/Birthday : Alamat website setelah online}
        {--out=docs : Folder hasil build (GitHub Pages membaca folder docs/)}',
    function () {
        $url = rtrim($this->option('url'), '/');
        $out = base_path($this->option('out'));

        // asset() harus menunjuk ke alamat GitHub Pages, bukan localhost
        URL::forceRootUrl($url);
        if (str_starts_with($url, 'https://')) {
            URL::forceScheme('https');
        }

        $html = view('birthday.novi', ['staticBuild' => true])->render();

        File::ensureDirectoryExists($out);
        File::deleteDirectory("{$out}/birthday");
        File::copyDirectory(public_path('birthday'), "{$out}/birthday");
        File::put("{$out}/index.html", $html);
        File::put("{$out}/.nojekyll", ''); // GitHub Pages: sajikan file apa adanya

        $this->info("Versi statis dibuat di {$out}");
        $this->line("Setelah di-push dan GitHub Pages aktif, buka: {$url}/");
    },
)->purpose('Buat versi HTML statis untuk GitHub Pages (gacha diundi di browser, tidak tercatat di server)');

Artisan::command('birthday:reset-gift', function () {
    BirthdayGift::reset();
    $this->info('Pilihan hadiah dihapus. Gacha bisa dimainkan lagi.');
})->purpose('Hapus pilihan hadiah supaya gacha bisa dimainkan ulang (misalnya setelah uji coba)');
