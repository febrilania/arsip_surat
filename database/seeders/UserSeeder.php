<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Ubing',
            'username' => 'admin1',
            'email' => 'ubingwbc0714@gmail.com',
            'password' => Hash::make('ubing@123'),
            'role' => 'admin',
            'profile_photo' => 'default.png',
        ]);
    }
}
