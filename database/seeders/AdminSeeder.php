<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(

            [
                'email' => 'admin@123.com',
            ],

            [
                'name' => 'Administrator',

                'role' => 'admin',

                'password' => Hash::make('Admin@123'),

                'email_verified_at' => now(),
            ]

        );
    }
}