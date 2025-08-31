<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PasienSeeder extends Seeder
{
    public function run()
    {
        DB::table('pasien')->insert([
            ['nama_pasien' => 'Budi', 'alamat' => 'Cirebon', 'no_telpon' => '0811', 'rumah_sakit_id' => 1],
            ['nama_pasien' => 'Ani', 'alamat' => 'Bandung', 'no_telpon' => '0822', 'rumah_sakit_id' => 2],
        ]);
    }
}
