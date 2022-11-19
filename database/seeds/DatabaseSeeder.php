<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            IndoRegionProvinceSeeder::class,
            IndoRegionRegencySeeder::class,
            IndoRegionDistrictSeeder::class,
            IndoRegionVillageSeeder::class,
            RoleSeeder::class,
            IndexSeeder::class,
            Index1Seeder::class,
            KategoriSeeder::class,
            AlamatSeeder::class,
            AntapaniSeeder::class,
            SukajadiSeeder::class,
            UjungberungSeeder::class,
            KirconSeeder::class,
            OrderSeeder::class,
        ]);
    }
}
