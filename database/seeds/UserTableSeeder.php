<?php

use Illuminate\Database\Seeder;
use App\User;
use Faker\Factory;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('id_ID');

        foreach (\App\Support\Role::ALL as $role) {
            if ($role == \App\Support\Role::ADMIN) {
                $user = User::create([
                    'name' => "ADMIN",
                    'username' => "admin",
                    'email' => "admin@bagasku.com",
                    'password' => bcrypt('secret'),
                    'role' => $role
                ]);
                \App\Model\Bio::create(['user_id' => $user->id]);
            } elseif ($role == \App\Support\Role::ROOT) {
                $user = User::create([
                    'name' => "ADMIN",
                    'username' => "root",
                    'email' => "root@bagasku.com",
                    'password' => bcrypt('secret'),
                    'role' => $role
                ]);
                \App\Model\Bio::create(['user_id' => $user->id]);

            } elseif ($role == \App\Support\Role::OTHER) {
                for ($c = 0; $c < (($role == \App\Support\Role::OTHER) ? 20 : 2); $c++) {
                    $email = $faker->safeEmail;
                    $user = User::create([
                        'name' => $faker->name,
                        'username' => strtok($email, '@'),
                        'email' => $email,
                        'password' => bcrypt('secret'),
                        'role' => $role
                    ]);

                    $bank = array("BCA", "BRI", "BNI", "BTN",'Mandiri');
                    \App\Model\Bio::create([
                        'user_id' => $user->id,
                        'status' => $faker->sentence,
                        'rekening' => $faker->creditCardNumber,
                        'an' => $user->name,
                        'bank' => $bank[array_rand($bank)]
                    ]);

                    $arr = array("3.5", "4", "4.5", "5");
                    \App\Model\Testimoni::create([
                        'user_id' => $user->id,
                        'deskripsi' => $faker->sentence,
                        'bintang' => $arr[array_rand($arr)]
                    ]);
                }
            }
        }
    }
}
