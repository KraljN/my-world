<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
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
                'order' => 10,
                'route' => '/home',
                'menu_party_id' => 1,
                'created_at' => now()
            ],
            [
                'order' => 20,
                'route' => '/categories/1',
                'menu_party_id' => 3,
                'created_at' => now()
            ],
            [
                'order' => 30,
                'route' => '/categories/2',
                'menu_party_id' => 4,
                'created_at' => now()
            ],
            [
                'order' => 40,
                'route' => '/categories/3',
                'menu_party_id' => 5,
                'created_at' => now()
            ],
            [
                'order' => 60,
                'route' => '/contact',
                'menu_party_id' => 2,
                'created_at' => now()
            ],
        ];

        foreach ($seed as $row){
            DB::table('menus')->insert($row);
        }
    }
}
