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

class Index1Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();


        for($i = 0; $i < 10; $i++) {

            $superadmin2 = User::create([
                'name' => 'Client Kab'.' '.$faker->name,
                'email'=> 'clientkab'.''.$faker->unique()->numberBetween(11,20).''.'@gmail.com',
                'password' => bcrypt('password'),
                'status' => '1',
                'created_at' => date('Y-m-d H:i:s')
            ]);
            $superadmin2->assignRole('client');
            $id = Client::insertGetId([
                'user_id' => $superadmin2->id,
                'photo' => 'avatar.png',
                'phone' => $faker->unique()->numberBetween(6285111200100,6285111200110),
                'dateBirth' => date('1997-01-01 H:i:s'),
                'placeBirth' => 'Bandung',
                'status' => '1',
                'created_at'    => date('Y-m-d H:i:s')
            ]);



            $id=$faker->randomElement((['3204110001','3204110002','3204110003','3204110004',
            '3204110005','3204110006','3204110007','3204110008','3204110009','3204110010'
        ,'3204110011','3204110012','3204110013','3204110014']));

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
                'name' => 'Taylor Kab'.' '.$faker->name,
                'email'=> 'taylorkab'.''.$faker->unique()->numberBetween(41,60).''.'@gmail.com',
                'password' => bcrypt('password'),
                'status' => '1',
                'created_at' => date('Y-m-d H:i:s')
            ]);
            $superadmin3->assignRole('taylor');
            $id = Taylor::insertGetId([
                'user_id' => $superadmin3->id,
                'photo' => 'avatar.png',
                'phone' => $faker->unique()->numberBetween(6285111200111,6285111200130),
                'dateBirth' => date('1997-01-01 H:i:s'),
                'placeBirth' => 'Bandung',
                'rating' => rand(0, 5),
                'status' => '1',
                'created_at'    => date('Y-m-d H:i:s')
            ]);
            $id=$faker->randomElement((['3204110001','3204110002','3204110003','3204110004',
            '3204110005','3204110006','3204110007','3204110008','3204110009','3204110010'
        ,'3204110011','3204110012','3204110013','3204110014']));

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
                'name' => 'Convection Kab'.' '.$faker->name,
                'email'=> 'convectionkab'.''.$faker->unique()->numberBetween(71,80).''.'@gmail.com',
                'password' => bcrypt('password'),
                'status' => '1',
                'created_at' => date('Y-m-d H:i:s')
            ]);
            $superadmin4->assignRole('convection');
            $id = Convection::insertGetId([
                'user_id' => $superadmin4->id,
                'photo' => 'avatar.png',
                'phone' => $faker->unique()->numberBetween(6285111200131,6285111200141),
                'dateBirth' => date('1997-01-01 H:i:s'),
                'placeBirth' => 'Bandung',
                'status' => '1',
                'created_at'    => date('Y-m-d H:i:s')
            ]);

            $id=$faker->randomElement((['3204110001','3204110002','3204110003','3204110004',
            '3204110005','3204110006','3204110007','3204110008','3204110009','3204110010'
        ,'3204110011','3204110012','3204110013','3204110014']));

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
