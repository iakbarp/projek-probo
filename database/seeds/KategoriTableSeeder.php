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

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (static::KategoriArray as $kategori) {
            \App\Model\Kategori::create([
                'nama' => $kategori
            ]);
        }
    }
}
