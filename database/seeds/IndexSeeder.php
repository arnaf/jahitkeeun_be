<?php

use App\User;
use App\Admin;
use App\Client;
use App\Taylor;
use App\Convection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class IndexSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        $superadmin1 = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password')
        ]);

        $superadmin1->assignRole('admin');

        $id = Admin::insertGetId([
            'user_id' => $superadmin1->id,
            'photo' => 'avatar.png',
            'phone' => '0811115555',
            'dateBirth' => date('1996-01-01 H:i:s'),
            'placeBirth' => 'Bandung',
            'status' => '1',
            'created_at'    => date('Y-m-d H:i:s')
        ]);



        for($i = 0; $i < 10; $i++) {
            $superadmin2 = User::create([
                'name' => 'client'.''.$faker->unique()->numberBetween(1,10),
                'email'=> 'client'.''.$faker->unique()->numberBetween(11,20).''.'@gmail.com',
                'password' => bcrypt('password'),
                'created_at' => date('Y-m-d H:i:s')
            ]);
            $superadmin2->assignRole('client');
            $id = Client::insertGetId([
                'user_id' => $superadmin2->id,
                'photo' => 'avatar.png',
                'phone' => $faker->unique()->numberBetween(6281111200100,6281111200110),
                'dateBirth' => date('1997-01-01 H:i:s'),
                'placeBirth' => 'Bandung',
                'status' => '1',
                'created_at'    => date('Y-m-d H:i:s')
            ]);


        }

        for($i = 0; $i < 20; $i++) {
            $superadmin3 = User::create([
                'name' => 'taylor'.''.$faker->unique()->numberBetween(21,40),
                'email'=> 'taylor'.''.$faker->unique()->numberBetween(41,60).''.'@gmail.com',
                'password' => bcrypt('password'),
                'created_at' => date('Y-m-d H:i:s')
            ]);
            $superadmin3->assignRole('taylor');
            $id = Taylor::insertGetId([
                'user_id' => $superadmin3->id,
                'photo' => 'avatar.png',
                'phone' => $faker->unique()->numberBetween(6281111200111,6281111200130),
                'dateBirth' => date('1997-01-01 H:i:s'),
                'placeBirth' => 'Bandung',
                'status' => '1',
                'created_at'    => date('Y-m-d H:i:s')
            ]);
        }
        for($i = 0; $i < 10; $i++) {
            $superadmin4 = User::create([
                'name' => 'convection'.''.$faker->unique()->numberBetween(61,70),
                'email'=> 'convection'.''.$faker->unique()->numberBetween(71,80).''.'@gmail.com',
                'password' => bcrypt('password'),
                'created_at' => date('Y-m-d H:i:s')
            ]);
            $superadmin4->assignRole('convection');
            $id = Convection::insertGetId([
                'user_id' => $superadmin4->id,
                'photo' => 'avatar.png',
                'phone' => $faker->unique()->numberBetween(6281111200131,6281111200141),
                'dateBirth' => date('1997-01-01 H:i:s'),
                'placeBirth' => 'Bandung',
                'status' => '1',
                'created_at'    => date('Y-m-d H:i:s')
            ]);
        }
        Artisan::call('passport:install');
    }
}
