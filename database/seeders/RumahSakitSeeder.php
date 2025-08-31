<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RumahSakitSeeder extends Seeder
{
    public function run()
    {
        DB::table('rumah_sakit')->insert([
            ['nama_rumah_sakit' => 'RS Harapan', 'alamat' => 'Jl. Bandung', 'email' => 'rs1@mail.com', 'telepon' => '021111'],
            ['nama_rumah_sakit' => 'RS Sehat', 'alamat' => 'Jl. Jakarta', 'email' => 'rs2@mail.com', 'telepon' => '021222'],
        ]);
    }
}
