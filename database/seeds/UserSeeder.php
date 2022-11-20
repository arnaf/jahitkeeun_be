<?php
use App\User;
use App\Client;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        //
        $superadmin1 = User::create([
            'name' => 'arnaf',
            'email' => 'arvi@gmail.com',
            'status' => '1',
            'password' => bcrypt('client123')
        ]);

        $id = Client::insertGetId([
            'user_id' => $superadmin1->id,
            'photo' => 'avatar.png',
            'phone' => '0811115555',
            'dateBirth' => date('1996-01-01 H:i:s'),
            'placeBirth' => 'Bandung',
            'status' => '1',
            'created_at'    => date('Y-m-d H:i:s')
        ]);

        $superadmin2 = User::create([
            'name' => 'pinan',
            'email'=> 'pinan@gmail.com',
            'password' => bcrypt('client123')
        ]);

        $id = Client::insertGetId([
            'user_id' => $superadmin2->id,
            'photo' => 'avatar.png',
            'phone' => '0811116666',
            'dateBirth' => date('1997-01-01 H:i:s'),
            'placeBirth' => 'Bandung',
            'status' => '1',
            'created_at'    => date('Y-m-d H:i:s')
        ]);


        $superadmin1->assignRole('client');
        $superadmin2->assignRole('client');
    }
}
