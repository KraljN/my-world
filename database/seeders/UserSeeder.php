<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seed = [
            [
                'first_name' => 'Nikola',
                'last_name' => 'Kralj',
                'username' => 'king',
                'email' => 'admin@gmail.com',
                'password' => '$2a$10$VQaM878xTsTYldmYaoS9MuG8O6TTxf6RTnKlA1C7Awhp2/Rn.mk9S',
                'image_id' => 1,
                'activated' => 1,
                'created_at' => now()
            ],
            [
                'first_name' => 'Petar',
                'last_name' => 'Peric',
                'username' => 'pera',
                'email' => 'user@gmail.com',
                'password' => '$2a$10$285bxVepBiYd02WO/t0DWu1OpSt5VOc3DtN1Q910bk8lOBkPq/8Y.',
                'image_id' => 1,
                'activated' => 1,
                'created_at' => now()
            ]
        ];

        foreach ($seed as $row){
            DB::table('users')->insert($row);
        }
    }
}
