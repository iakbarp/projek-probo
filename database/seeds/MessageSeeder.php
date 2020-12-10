<?php

use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');

        $fahmi = \App\User::where('role', \App\Support\Role::OTHER)->whereHas('get_bio', function ($q) {
            $q->orderByDesc('total_bintang_klien');
        })->whereHas('get_bid')->whereHas('get_undangan')->first();

        $other=\App\User::where('id','!=',$fahmi->id)->limit(20)->get();


        foreach ($other as $row){
            $ids=[$fahmi->id,$row->id];

            foreach(range(0,50) as $i){
                $z=rand(0,1);
                \App\Model\Message::create([
                    'user_from'=>$ids[$z],
                    'user_to'=>$ids[$z==0?1:0],
                    'message'=>$faker->sentence(6),
                ]);
            }
        }
    }
}
