<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostCategorySeeder extends Seeder
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
                'post_id' => 1,
                'category_id' => 3,
            ],
            [
                'post_id' => 1,
                'category_id' => 1,
            ],
            [
                'post_id' => 2,
                'category_id' => 1,
            ],
            [
                'post_id' => 3,
                'category_id' => 2,
            ],
            [
                'post_id' => 4,
                'category_id' => 1,
            ],
            [
                'post_id' => 5,
                'category_id' => 3,
            ],
            [
                'post_id' => 6,
                'category_id' => 3,
            ],
        ];

        foreach ($seed as $row){
            DB::table('post_categories')->insert($row);
        }
    }
}
