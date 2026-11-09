<?php

namespace App\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Gacha hadiah ulang tahun: undian dilakukan di server, hasil pertama dikunci
 * di storage/app/private/birthday/novi-gift.json sehingga tidak bisa diulang.
 */
final class BirthdayGift
{
    private const FILE = 'birthday/novi-gift.json';

    /**
     * @return array<int, array{key: string, label: string, emoji: string, note: string}>
     */
    public static function options(): array
    {
        return config('birthday.gifts', []);
    }

    /**
     * Pilihan yang sudah tersimpan, atau null bila belum memilih.
     *
     * @return array{box: int, gift: string, arrangement: array<int, string>, picked_at: string}|null
     */
    public static function current(): ?array
    {
        $disk = Storage::disk('local');

        if (! $disk->exists(self::FILE)) {
            return null;
        }

        $choice = json_decode($disk->get(self::FILE), true);

        return is_array($choice) ? $choice : null;
    }

    /**
     * Mengacak isi semua kotak lalu membuka kotak yang dipilih.
     * Pilihan pertama yang berlaku; pemanggilan berikutnya mengembalikan hasil yang sama.
     */
    public static function pick(int $box): array
    {
        if ($existing = self::current()) {
            return $existing;
        }

        $arrangement = Arr::shuffle(array_column(self::options(), 'key'));

        $choice = [
            'box' => $box,
            'gift' => $arrangement[$box],
            'arrangement' => $arrangement,
            'picked_at' => now()->toIso8601String(),
        ];

        Storage::disk('local')->put(self::FILE, json_encode($choice, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        Log::info('Novi memilih hadiah ulang tahun', $choice);

        return $choice;
    }

    public static function label(string $key): string
    {
        $gift = Arr::first(self::options(), fn (array $option) => $option['key'] === $key);

        return $gift ? "{$gift['emoji']} {$gift['label']}" : $key;
    }

    public static function reset(): bool
    {
        return Storage::disk('local')->delete(self::FILE);
    }
}
