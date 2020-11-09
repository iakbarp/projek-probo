<?php

use Illuminate\Database\Seeder;

class ProyekLayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');

        $i = 0;
        $klien_ids = [];
        $client = \App\User::where('role', \App\Support\Role::OTHER)->take(10)->get();
        foreach ($client as $klien) {
            $title = \Faker\Factory::create()->jobTitle;
            \App\Model\Project::create([
                'user_id' => $klien->id,
                'judul' => $title,
                'permalink' => preg_replace("![^a-z0-9]+!i", "-", strtolower($title)),
                'deskripsi' => '<p>' . $faker->paragraph . '</p>',
                'waktu_pengerjaan' => rand(1, 10),
                'harga' => $faker->numerify('########'),
                'pribadi' => false,
                'subkategori_id' => rand(\App\Model\SubKategori::min('id'), \App\Model\SubKategori::max('id'))
            ]);

            $title2 = \Faker\Factory::create()->jobTitle;
            \App\Model\Project::create([
                'user_id' => $klien->id,
                'judul' => $title2,
                'permalink' => preg_replace("![^a-z0-9]+!i", "-", strtolower($title2)),
                'deskripsi' => '<p>' . $faker->paragraph . '</p>',
                'waktu_pengerjaan' => rand(1, 10),
                'harga' => $faker->numerify('########'),
                'pribadi' => false,
                'subkategori_id' => rand(\App\Model\SubKategori::min('id'), \App\Model\SubKategori::max('id'))
            ]);

            $klien_ids[$i] = $klien->id;
            $i = $i + 1;
        }

        $pekerja = \App\User::where('role', \App\Support\Role::OTHER)
            ->whereNotIn('id', $klien_ids)->get();

        $arr_pekerja = $pekerja->pluck('id')->toArray();
        $arr_rate = ["3.5", "4", "4.5", "5"];
        foreach (\App\Model\Project::take(12)->get() as $proyek) {
            $user_id = $arr_pekerja[array_rand($arr_pekerja)];
            \App\Model\Bid::create([
                'user_id' => $user_id,
                'proyek_id' => $proyek->id,
                'tolak' => false
            ]);

            $pengerjaan = \App\Model\Pengerjaan::create([
                'user_id' => $user_id,
                'proyek_id' => $proyek->id,
                'selesai' => true,
                'tautan' => $faker->imageUrl(),
            ]);

            \App\Model\Pembayaran::create([
                'proyek_id' => $proyek->id,
                'jumlah_pembayaran' => $proyek->harga
            ]);

            $review_klien = \App\Model\Review::create([
                'user_id' => $pengerjaan->user_id,
                'proyek_id' => $proyek->id,
                'deskripsi' => '<p>' . $faker->paragraph . '</p>',
                'bintang' => $arr_rate[array_rand($arr_rate)]
            ]);
            $proyek->get_user->get_bio->update([
                'total_bintang_klien' => $proyek->get_user->get_bio->total_bintang_klien + $review_klien->bintang
            ]);

            $review_pekerja = \App\Model\ReviewWorker::create([
                'user_id' => $proyek->user_id,
                'pengerjaan_id' => $pengerjaan->id,
                'deskripsi' => '<p>' . $faker->paragraph . '</p>',
                'bintang' => $arr_rate[array_rand($arr_rate)]
            ]);
            $pengerjaan->get_user->get_bio->update([
                'total_bintang_pekerja' => $pengerjaan->get_user->get_bio->total_bintang_pekerja + $review_pekerja->bintang
            ]);
        }

        foreach ($pekerja as $row) {
            $title3 = \Faker\Factory::create()->jobTitle;
            $service = \App\Model\Services::create([
                'user_id' => $row->id,
                'subkategori_id' => rand(\App\Model\SubKategori::min('id'), \App\Model\SubKategori::max('id')),
                'harga' => $faker->numerify('########'),
                'deskripsi' => '<p>' . $faker->paragraph . '</p>',
                'hari_pengerjaan' => rand(1, 30),
                'judul' => $title3,
                'permalink' => preg_replace("![^a-z0-9]+!i", "-", strtolower($title3)),
            ]);

            $user_id = $klien_ids[array_rand($klien_ids)];
            $pengeraanLayanan = \App\Model\PengerjaanLayanan::create([
                'service_id' => $service->id,
                'user_id' => $user_id,
                'selesai' => true,
                'tautan' => $faker->imageUrl()
            ]);

            \App\Model\PembayaranLayanan::create([
                'pengerjaan_layanan_id' => $pengeraanLayanan->id,
                'jumlah_pembayaran' => $service->harga
            ]);

            \App\Model\UlasanService::create([
                'user_id' => $pengeraanLayanan->user_id,
                'pengerjaan_layanan_id' => $pengeraanLayanan->id,
                'deskripsi' => '<p>' . $faker->paragraph . '</p>',
                'bintang' => $arr_rate[array_rand($arr_rate)]
            ]);

            \App\Model\Undangan::create([
                'user_id' => $row->id,
                'proyek_id' => rand(\App\Model\Project::min('id'), \App\Model\Project::max('id'))
            ]);

            \App\Model\Undangan::create([
                'user_id' => $row->id,
                'proyek_id' => rand(\App\Model\Project::min('id'), \App\Model\Project::max('id'))
            ]);
        }

        $fq = \App\User::where('role', \App\Support\Role::OTHER)->whereHas('get_bio', function ($q) {
            $q->orderByDesc('total_bintang_klien');
        })->whereHas('get_bid')->whereHas('get_undangan')->first();

        $fq->update([
            'name' => 'Fiqy Ainuzzaqy',
            'username' => 'fq_whysoserious',
            'email' => 'fiqy_a@icloud.com'
        ]);
        $fq->get_bio->update([
            'tgl_lahir' => '1997-10-15',
            'jenis_kelamin' => 'pria',
            'kewarganegaraan' => 'Indonesia',
            'kota_id' => 259,
            'alamat' => 'Jl. Hikmat 50A Betro, Sedati',
            'kode_pos' => '61253',
            'hp' => '081356598237',
            'status' => 'Talk slowly, think quickly!',
            'summary' => $faker->paragraph,
            'website' => 'http://rabbit-media.net'
        ]);
        \App\Model\Bahasa::create([
            'user_id' => $fq->id,
            'nama' => 'Indonesia',
            'tingkatan' => 'asli'
        ]);
        \App\Model\Bahasa::create([
            'user_id' => $fq->id,
            'nama' => 'Inggris',
            'tingkatan' => 'percakapan'
        ]);
        \App\Model\Skill::create([
            'user_id' => $fq->id,
            'nama' => 'Pemrograman Web',
            'tingkatan' => 'menengah'
        ]);
    }
}
