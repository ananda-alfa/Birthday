<?php

use App\Support\BirthdayGift;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

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

Artisan::command('birthday:reset-gift', function () {
    BirthdayGift::reset();
    $this->info('Pilihan hadiah dihapus. Gacha bisa dimainkan lagi.');
})->purpose('Hapus pilihan hadiah supaya gacha bisa dimainkan ulang (misalnya setelah uji coba)');
