<?php

use App\User;
use App\Admin;
use App\Client;
use App\Taylor;
use App\Address;
use App\Convection;
use App\AddressLabel;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Artisan;

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



        $addressesLabel1 = AddressLabel::insert([
            'name' => 'Utama'
        ]);

        $addressesLabel2 = AddressLabel::insert([
            'name' => 'Pengiriman'
        ]);

        $addressesLabel3 = AddressLabel::insert([
            'name' => 'Penjemputan'
        ]);


        $superadmin1 = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'status' => '1'
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

        $id = '3273010003';

        $alamat = DB::table('provinces')
        ->join('regencies', 'provinces.id', '=', 'regencies.province_id')
        ->join('districts', 'regencies.id', '=', 'districts.regency_id')
        ->join('villages', 'districts.id', '=', 'villages.district_id')
        ->where('villages.id' ,'=', $id)
            ->select([
                'provinces.id as provinsi', 'regencies.id as regencies',
                'districts.id as districts','villages.id as village'
            ])
            // ->select([
            //     'provinces.name as provinsi', 'regencies.name as regencies',
            //     'districts.name as districts','villages.name as village'
            // ])
            ->first();



        $id = Address::insertGetId([
            'user_id' => $superadmin1->id,
            'fullAddress' => 'Jl Kenangan',
            'posCode' => '40000',
            'province_id' => $alamat->provinsi,
            'regency_id' => $alamat->regencies,
            'district_id' => $alamat->districts,
            'village_id' => $alamat->village,
            'lat' => '',
            'long' => '',
            'addresslabel_id' => 1,
            'created_at'    => date('Y-m-d H:i:s')
        ]);



        for($i = 0; $i < 10; $i++) {

            $superadmin2 = User::create([
                'name' => 'Client'.' '.$faker->name,
                'email'=> 'client'.''.$faker->unique()->numberBetween(11,20).''.'@gmail.com',
                'password' => bcrypt('password'),
                'status' => '1',
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


            $id=$faker->randomElement((['3273010001','3273010002','3273010003','3273010004',
            '3273010005','3273010006','3273010007','3273010008']));

        $alamat = DB::table('provinces')
        ->join('regencies', 'provinces.id', '=', 'regencies.province_id')
        ->join('districts', 'regencies.id', '=', 'districts.regency_id')
        ->join('villages', 'districts.id', '=', 'villages.district_id')
        ->where('villages.id' ,'=', $id)
            ->select([
                'provinces.id as provinsi', 'regencies.id as regencies',
                'districts.id as districts','villages.id as village'
            ])
            // ->select([
            //     'provinces.name as provinsi', 'regencies.name as regencies',
            //     'districts.name as districts','villages.name as village'
            // ])
            ->first();


        $id = Address::insertGetId([
            'user_id' => $superadmin2->id,
            'fullAddress' => 'Jl Kenangan',
            'posCode' => '40000',
            'province_id' => $alamat->provinsi,
            'regency_id' => $alamat->regencies,
            'district_id' => $alamat->districts,
            'village_id' => $alamat->village,
            'lat' => '',
            'long' => '',
            'addresslabel_id' => 1,
            'created_at'    => date('Y-m-d H:i:s')
        ]);


        }

        for($i = 0; $i < 20; $i++) {
            $superadmin3 = User::create([
                'name' => 'Taylor'.' '.$faker->name,
                'email'=> 'taylor'.''.$faker->unique()->numberBetween(41,60).''.'@gmail.com',
                'password' => bcrypt('password'),
                'status' => '1',
                'created_at' => date('Y-m-d H:i:s')
            ]);
            $superadmin3->assignRole('taylor');
            $id = Taylor::insertGetId([
                'user_id' => $superadmin3->id,
                'photo' => 'avatar.png',
                'phone' => $faker->unique()->numberBetween(6281111200111,6281111200130),
                'dateBirth' => date('1997-01-01 H:i:s'),
                'placeBirth' => 'Bandung',
                'rating' => rand(0, 5),
                'status' => '1',
                'created_at'    => date('Y-m-d H:i:s')
            ]);
            $id=$faker->randomElement((['3273010001','3273010002','3273010003','3273010004',
            '3273010005','3273010006','3273010007','3273010008']));

            $alamat = DB::table('provinces')
            ->join('regencies', 'provinces.id', '=', 'regencies.province_id')
            ->join('districts', 'regencies.id', '=', 'districts.regency_id')
            ->join('villages', 'districts.id', '=', 'villages.district_id')
            ->where('villages.id' ,'=', $id)
                ->select([
                    'provinces.id as provinsi', 'regencies.id as regencies',
                    'districts.id as districts','villages.id as village'
                ])
                // ->select([
                //     'provinces.name as provinsi', 'regencies.name as regencies',
                //     'districts.name as districts','villages.name as village'
                // ])
                ->first();


            $id = Address::insertGetId([
                'user_id' => $superadmin3->id,
                'fullAddress' => 'Jl Kenangan',
                'posCode' => '40000',
                'province_id' => $alamat->provinsi,
                'regency_id' => $alamat->regencies,
                'district_id' => $alamat->districts,
                'village_id' => $alamat->village,
                'lat' => '',
                'long' => '',
                'addresslabel_id' => 1,
                'created_at'    => date('Y-m-d H:i:s')
            ]);

        }
        for($i = 0; $i < 10; $i++) {
            $superadmin4 = User::create([
                'name' => 'Convection'.' '.$faker->name,
                'email'=> 'convection'.''.$faker->unique()->numberBetween(71,80).''.'@gmail.com',
                'password' => bcrypt('password'),
                'status' => '1',
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

            $id=$faker->randomElement((['3273010001','3273010002','3273010003','3273010004',
            '3273010005','3273010006','3273010007','3273010008']));

            $alamat = DB::table('provinces')
            ->join('regencies', 'provinces.id', '=', 'regencies.province_id')
            ->join('districts', 'regencies.id', '=', 'districts.regency_id')
            ->join('villages', 'districts.id', '=', 'villages.district_id')
            ->where('villages.id' ,'=', $id)
                ->select([
                    'provinces.id as provinsi', 'regencies.id as regencies',
                    'districts.id as districts','villages.id as village'
                ])
                // ->select([
                //     'provinces.name as provinsi', 'regencies.name as regencies',
                //     'districts.name as districts','villages.name as village'
                // ])
                ->first();


            $id = Address::insertGetId([
                'user_id' => $superadmin4->id,
                'fullAddress' => 'Jl Kenangan',
                'posCode' => '40000',
                'province_id' => $alamat->provinsi,
                'regency_id' => $alamat->regencies,
                'district_id' => $alamat->districts,
                'village_id' => $alamat->village,
                'lat' => '',
                'long' => '',
                'addresslabel_id' => 1,
                'created_at'    => date('Y-m-d H:i:s')
            ]);
        }
        Artisan::call('passport:install');
    }
}
