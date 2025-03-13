<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mahasiswa')->insert([
            [
                'user_id' => 2,
                'nim' => '2211523014',
                'nama_lengkap' => 'Rania Shofi Malika',
                'program_studi' => 'Sistem Informasi',
                'angkatan' => '2022',
                'no_hp' => '081234567890',
                'gambar' => null
            ],
            [
                'user_id' => 3,
                'nim' => '2211521004',
                'nama_lengkap' => 'Nadia Deari Hanifah',
                'program_studi' => 'Sistem Informasi',
                'angkatan' => '2022',
                'no_hp' => '081234567891',
                'gambar' => null
            ],
            [
                'user_id' => 4,
                'nim' => '2211523010',
                'nama_lengkap' => 'Azhra Meisa Khairani',
                'program_studi' => 'Sistem Informasi',
                'angkatan' => '2022',
                'no_hp' => '081234567892',
                'gambar' => null
            ]

        ]);
    }
}
