<?php

use App\User;
use Illuminate\Database\Seeder;

class TaylorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $client = User::create([
            'name' => 'client',
            'email' => 'taylor1@mail.com',

        ]);
    }
}
