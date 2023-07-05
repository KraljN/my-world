<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
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
                'name' => 'Kids',
                'menu_party_id' => 3,
                'created_at' => now()
            ],
            [
                'name' => 'Travel',
                'menu_party_id' => 4,
                'created_at' => now()
            ],
            [
                'name' => 'Books',
                'menu_party_id' => 5,
                'created_at' => now()
            ],
        ];

        foreach ($seed as $row){
            DB::table('categories')->insert($row);
        }
    }
}
