<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            ClassSeeder::class,
            StreamSeeder::class,
            AssasmenetSeeder::class,
            PaymentTypeSeeder::class,
        ]);
    }
}
