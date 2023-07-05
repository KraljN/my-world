<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuItemSeeder extends Seeder
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
                'name' => 'Home',
                'menu_party_id' => 1,
                'created_at' => now()
            ],
            [
                'name' => 'Contact Us',
                'menu_party_id' => 2,
                'created_at' => now()
            ]
        ];

        foreach ($seed as $row){
            DB::table('menu_items')->insert($row);
        }
    }
}
