<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
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
                'name' => 'Food',
                'created_at' => now()
            ],
            [
                'name' => 'Art',
                'created_at' => now()
            ],
            [
                'name' => 'Beauty',
                'created_at' => now()
            ],
            [
                'name' => 'Fashion',
                'created_at' => now()
            ],
            [
                'name' => 'Life',
                'created_at' => now()
            ],
            [
                'name' => 'Travel',
                'created_at' => now()
            ]
        ];

        foreach ($seed as $row){
            DB::table('tags')->insert($row);
        }
    }
}
