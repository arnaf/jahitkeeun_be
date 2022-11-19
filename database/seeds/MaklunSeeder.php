<?php

use App\Maklun;
use App\MaklunApplies;
use App\Portofolio;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

class MaklunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();


        // Taylor Id 3
        // $user->premiumDate= now();
        // $date = Carbon::createFromFormat('Y.m.d', $user->premiumDate);
        // $daysToAdd = 14;
        // $date = $date->addDays($daysToAdd);

        for($i = 32; $i <= 40; $i++) {
            $maklun = Maklun::insert([
                'title' => 'DIBUTUHKAN SEGERA OP. JAHIT GAUN PENGANTIN',
                'desc' => 'Saat ini kami membutuhkan karyawan untuk posisi sebagai Tukang Jahit (Sewing) yang berkompeten. Dibutuhkan staf yang dapat bekerja dengan ritme',
                'price' => $faker->randomElement(([5000000,4000000])),

                'dueTime' => now()->addDays(14),
                'status' => 1,
                'maklun_maker_id' => $i,
                'created_at' => date('Y-m-d H:i:s'),

            ]);

        }



        $service=1;
        for($i = 1; $i <= 4; $i++) {
            $cart = MaklunApplies::insert([
                'status'  => 'Apply',
                'bid'  => $faker->randomElement(([5500000,6000000])),
                'taylor_id'  => $service,
                'maklun_id'  => $i,
                'desc' => 'Saya Sanggup Menyelesaikan dengan baik dan berorientasi kepuasan Pelanggan',
            ]);
            $service++;
        }

        $service=5;
        for($i = 5; $i <= 8; $i++) {
            $cart = MaklunApplies::insert([
                'status'  => 'Apply',
                'bid'  => $faker->randomElement(([5500000,6000000])),
                'taylor_id'  => $service,
                'maklun_id'  => $i,
                'desc' => 'Saya Sanggup Menyelesaikan dengan baik dan berorientasi kepuasan Pelanggan',
            ]);
            $service++;
        }


        $service=9;
        for($i = 1; $i <= 8; $i++) {
            $cart = MaklunApplies::insert([
                'status'  => 'Apply',
                'bid'  => $faker->randomElement(([5500000,6000000])),
                'taylor_id'  => $service,
                'maklun_id'  => $i,
                'desc' => 'Saya Sanggup Menyelesaikan dengan baik dan berorientasi kepuasan Pelanggan',
            ]);
            $service++;
        }

        $service=17;
        for($i = 1; $i <= 8; $i++) {
            $cart = MaklunApplies::insert([
                'status'  => 'Apply',
                'bid'  => $faker->randomElement(([5500000,6000000])),
                'taylor_id'  => $service,
                'maklun_id'  => $i,
                'desc' => 'Saya Sanggup Menyelesaikan dengan baik dan berorientasi kepuasan Pelanggan',
            ]);
            $service++;
        }

        for($a = 1; $a <= 4; $a++){
        for($i = 1; $i <= 65; $i++) {
            $maklun = Portofolio::insert([

                'desc' => $faker->randomElement((['Celana Mantap','Dress Keren','Batik Nusantara','Kemeja Mewah Bro'])),
                'photo1'  => 'photo1.png',
                'photo2'  => 'photo2.png',
                'photo3'  => 'photo3.png',
                'photo4'  => 'photo4.png',
                'photo5'  => 'photo5.png',
                'taylor_id' => $i,
                'created_at' => date('Y-m-d H:i:s'),

            ]);

        }
    }








    }
}
