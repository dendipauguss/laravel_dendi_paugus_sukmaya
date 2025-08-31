<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Dendi Paugus Sukmaya',
                'email' => 'dendipauguss1111@gmail.com',
                'username' => 'dendipauguss',
                'password' => Hash::make('dendipauguss11')
            ],
        ]);
    }
}
