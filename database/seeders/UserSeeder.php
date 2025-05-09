<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin'
            ],
            [
            'email' => 'rania@gmail.com',
            'password' => Hash::make('rania123'),
            'role' => 'mahasiswa'
            ],
            [
            'email' => 'nadia@gmail.com',
            'password' => Hash::make('nadia123'),
            'role' => 'mahasiswa'
            ],
            [
            'email' => 'meisa@gmail.com',
            'password' => Hash::make('meisa123'),
            'role' => 'mahasiswa'
            ]
    ]);
    }
}
