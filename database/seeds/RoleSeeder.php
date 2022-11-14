<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $client = Role::create([
            'name' => 'client',
            'guard_name' => 'web',

        ]);

        $taylor = Role::create([
            'name' => 'taylor',
            'guard_name' => 'web',

        ]);

        $convection = Role::create([
            'name' => 'convection',
            'guard_name' => 'web',

        ]);

        $admin = Role::create([
            'name' => 'admin',
            'guard_name' => 'web',

        ]);
    }
}
