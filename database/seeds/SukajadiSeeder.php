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
use Faker\Factory as Faker;

class SukajadiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();


        for($i = 0; $i < 5; $i++) {

            $superadmin2 = User::create([
                'name' => $faker->name,
                'email'=> 'clientsukajadi'.''.$faker->unique()->numberBetween(1,5).''.'@gmail.com',
                'password' => bcrypt('password'),
                'created_at' => date('Y-m-d H:i:s')
            ]);
            $superadmin2->assignRole('client');
            $id = Client::insertGetId([
                'user_id' => $superadmin2->id,
                'photo' => 'avatar.png',
                'phone' => $faker->unique()->numberBetween(6282211200300,6282211200305),
                'dateBirth' => date('1997-01-01 H:i:s'),
                'placeBirth' => 'Bandung',
                'status' => '1',
                'created_at'    => date('Y-m-d H:i:s')
            ]);


            $id=$faker->randomElement((['3273240001','3273240002','3273240003','3273240004',
            '3273240005']));

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
            'fullAddress' => 'Jl Cilenyi',
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

        for($i = 0; $i < 5; $i++) {
            $superadmin3 = User::create([
                'name' => 'Taylor'.' '.$faker->name,
                'email'=> 'taylorsukajadi'.''.$faker->unique()->numberBetween(6,10).''.'@gmail.com',
                'password' => bcrypt('password'),
                'created_at' => date('Y-m-d H:i:s')
            ]);
            $superadmin3->assignRole('taylor');
            $id = Taylor::insertGetId([
                'user_id' => $superadmin3->id,
                'photo' => 'avatar.png',
                'phone' => $faker->unique()->numberBetween(6282211300111,6282211300115),
                'dateBirth' => date('1997-01-01 H:i:s'),
                'placeBirth' => 'Bandung',
                'rating' => rand(0, 5),
                'status' => '1',
                'created_at'    => date('Y-m-d H:i:s')
            ]);
            $id=$faker->randomElement((['3273240001','3273240002','3273240003','3273240004',
            '3273240005']));

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
                'fullAddress' => 'Jl Soekarno Hatta',
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
        for($i = 0; $i < 5; $i++) {
            $superadmin4 = User::create([
                'name' => $faker->name,
                'email'=> 'convectionsukajadi'.''.$faker->unique()->numberBetween(11,15).''.'@gmail.com',
                'password' => bcrypt('password'),
                'created_at' => date('Y-m-d H:i:s')
            ]);
            $superadmin4->assignRole('convection');
            $id = Convection::insertGetId([
                'user_id' => $superadmin4->id,
                'photo' => 'avatar.png',
                'phone' => $faker->unique()->numberBetween(6282211400131,6282211400141),
                'dateBirth' => date('1997-01-01 H:i:s'),
                'placeBirth' => 'Bandung',
                'status' => '1',
                'created_at'    => date('Y-m-d H:i:s')
            ]);



            $id=$faker->randomElement((['3273240001','3273240002','3273240003','3273240004',
            '3273240005']));

            $alamat = DB::table('provinces')
            ->join('regencies', 'provinces.id', '=', 'regencies.province_id')
            ->join('districts', 'regencies.id', '=', 'districts.regency_id')
            ->join('villages', 'districts.id', '=', 'villages.district_id')
            ->where('villages.id' ,'=', $id)
                ->select([
                    'provinces.id as provinsi', 'regencies.id as regencies',
                    'districts.id as districts','villages.id as village'
                ])
                ->first();


            $id = Address::insertGetId([
                'user_id' => $superadmin4->id,
                'fullAddress' => 'Pagarsih',
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
