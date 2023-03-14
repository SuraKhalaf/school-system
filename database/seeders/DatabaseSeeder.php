<?php

namespace Database\Seeders;

use Database\Seeders\Init\RolesAndPermissionsSeeder;
use Database\Seeders\Init\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            UserSeeder::class,
        ]);
    }
}
