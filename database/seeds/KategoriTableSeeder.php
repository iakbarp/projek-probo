<?php

use Illuminate\Database\Seeder;

class KategoriTableSeeder extends Seeder
{
    const KategoriArray = [
        'Website',
        'Penulisan',
        'Desain & Multimedia',
        'Bisnis & Pemasaran Online',
        'Penerjemah',
        'Aplikasi Mobile',
        'Audio, Video & Photo',
        'Data Entry'
    ];

    const KategoriArrayIco = [
        'website.png',
        'penulisan.png',
        'design.png',
        'bisnis.png',
        'penerjemah.png',
        'mobile.png',
        'animasi.png',
        'entry.png'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (static::KategoriArray as $i=>$kategori) {
            \App\Model\Kategori::create([
                'nama' => $kategori,
                'img'=>static::KategoriArrayIco[$i]
            ]);
        }
    }
}
