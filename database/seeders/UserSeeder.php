<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Emilio Jasso',
                'email' => 'emilio@example.com',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Henry Enoch',
                'email' => 'henry@example.com',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Luis Diaz',
                'email' => 'luis@example.com',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Jorge Barlau',
                'email' => 'jorge@example.com',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Rafael Merlin',
                'email' => 'rafael@example.com',
                'password' => Hash::make('password123'),
            ],
        ]);
    }
}
