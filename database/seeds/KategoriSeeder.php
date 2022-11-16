<?php

use App\ServiceCategory;
use App\Service;
use App\Address;
use App\User;
use App\Admin;
use App\Client;
use App\Taylor;
use App\Convection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();



        $serviceCategory1 = ServiceCategory::insert([
            'name' => 'Gamis',
            'photo' => 'gamis.png'
        ]);

        $serviceCategory2 = ServiceCategory::insert([
            'name' => 'Kebaya / Atasan Tanpa Payet',
            'photo' => 'kebaya.png'
        ]);

        $serviceCategory3 = ServiceCategory::insert([
            'name' => 'Kemeja / Atasan ',
            'photo' => 'kemeja.png'
        ]);

        $serviceCategory4 = ServiceCategory::insert([
            'name' => 'Kemeja Batik ',
            'photo' => 'kemejabatik.png'
        ]);

        $serviceCategory5 = ServiceCategory::insert([
            'name' => 'Kerudung',
            'photo' => 'kerudung.png'
        ]);

        $serviceCategory6 = ServiceCategory::insert([
            'name' => 'Kupnat',
            'photo' => 'kupnat.png'
        ]);

        $serviceCategory7 = ServiceCategory::insert([
            'name' => 'Robek / Berlubang',
            'photo' => 'robek.png'
        ]);

        $serviceCategory8 = ServiceCategory::insert([
            'name' => 'Kancing',
            'photo' => 'kancing.png'
        ]);

    for($i = 1; $i <= 20; $i++) {
        $jasa1 = Service::insert([
            'name' => 'Jahit Exclude Bahan',
            'price' => 145000,
            'service_categories_id' => 1,
            'taylor_id' => $i,

        ]);
    }
    for($i = 1; $i <= 20; $i++) {

        $jasa2 = Service::insert([
            'name' => 'Permak Resize Ukuruan (Premium)',
            'price' => 135000,
            'service_categories_id' => 1,
            'taylor_id' => $i,
        ]);
    }
    for($i = 1; $i <= 20; $i++) {

        $jasa3 = Service::insert([
            'name' => 'Permak Resize Ukuruan (Reguler)',
            'price' => 100000,
            'service_categories_id' => 1,
            'taylor_id' => $i,
        ]);
    }
    for($i = 1; $i <= 20; $i++) {

        $jasa4 = Service::insert([
            'name' => 'Potong Panjang Bawah (Premium)',
            'price' => 105000,
            'service_categories_id' => 1,
            'taylor_id' => $i,
        ]);
    }
    for($i = 1; $i <= 20; $i++) {

        $jasa5 = Service::insert([
            'name' => 'Potong Panjang Bawah (Reguler)',
            'price' => 75000,
            'service_categories_id' => 1,
            'taylor_id' => $i,
        ]);
    }
    for($i = 1; $i <= 20; $i++) {

        $jasa6 = Service::insert([
            'name' => 'Resleting Ganti Resleting (Premium)',
            'price' => 85000,
            'service_categories_id' => 1,
            'taylor_id' => $i,
        ]);
    }
    for($i = 1; $i <= 20; $i++) {


        $jasa7 = Service::insert([
            'name' => 'Resleting Ganti Resleting (Reguler)',
            'price' => 60000,
            'service_categories_id' => 1,
            'taylor_id' => $i,
        ]);
    }




    }
}
