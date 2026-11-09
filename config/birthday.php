<?php

/*
|--------------------------------------------------------------------------
| Birthday microsite — pilihan hadiah gacha
|--------------------------------------------------------------------------
| Setiap hadiah butuh: key (unik, tanpa spasi), label, emoji, dan note
| (pesan manis yang muncul saat hadiah terbuka). Jumlah kotak di halaman
| otomatis mengikuti jumlah hadiah di sini.
*/

return [

    'gifts' => [
        [
            'key' => 'skincare',
            'label' => 'Skin Care',
            'emoji' => '🧴',
            'note' => 'Biar kulitmu makin glowing, walau buatku kamu sudah bersinar setiap hari.',
        ],
        [
            'key' => 'kerudung',
            'label' => 'Kerudung Buttonscarves',
            'emoji' => '🧕',
            'note' => 'Untuk melengkapi senyum cantikmu di setiap langkah.',
        ],
        [
            'key' => 'jam-tangan',
            'label' => 'Jam Tangan',
            'emoji' => '⌚',
            'note' => 'Supaya setiap detik yang kamu lalui terasa berharga, seperti kamu buatku.',
        ],
        [
            'key' => 'baju',
            'label' => 'Baju',
            'emoji' => '👗',
            'note' => 'Biar kamu makin cantik di setiap momen bahagiamu.',
        ],
    ],

];
