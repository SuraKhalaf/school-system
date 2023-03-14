<?php

namespace Database\Seeders;

use Database\Seeders\Test\CourseSeeder;
use Database\Seeders\Test\UserSeeder;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CourseSeeder::class,
        ]);
    }
}
