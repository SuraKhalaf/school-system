<?php

namespace Database\Seeders\Test;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers = User::factory(5)->create();
        foreach ($teachers as $teacher) {
            $teacher->assignRole('teacher');
        }

        $students = User::factory(100)->create();
        foreach ($students as $student) {
            $student->assignRole('student');
        }
    }
}
