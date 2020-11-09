<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call([
             KategoriTableSeeder::class,
             SubKategoriTableSeeder::class,
             NegaraTableSeeder::class,
             PovinsiTableSeeder::class,
             KotaTableSeeder::class,
             UserTableSeeder::class,
             ProyekLayananSeeder::class,
         ]);
    }
}
