<?php

namespace Database\Seeders\Init;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $isExist = User::where('email', 'admin@admin.com')->exists();
        if (! $isExist) {
            $admin = User::create([
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'phone' => '1234567890',
                'password' => Hash::make('12345678'),
            ]);
            $admin->assignRole('admin');
        }
    }
}
