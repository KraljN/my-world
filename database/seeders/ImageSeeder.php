<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImageSeeder extends Seeder
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
                'src' => 'default.png',
                'alt' => 'default image',
                'created_at' => now()
            ],
            [
                'src' => 'travel.jpg',
                'alt' => 'travel',
                'created_at' => now()
            ],
            [
                'src' => 'wedding.jpg',
                'alt' => 'wedding',
                'created_at' => now()
            ],
            [
                'src' => 'school.jpg',
                'alt' => 'school',
                'created_at' => now()
            ],
            [
                'src' => 'songs.jpg',
                'alt' => 'song listening',
                'created_at' => now()
            ],
            [
                'src' => 'books.jpg',
                'alt' => 'bookshelf',
                'created_at' => now()
            ],
            [
                'src' => 'cookbook.jpg',
                'alt' => 'cookbook',
                'created_at' => now()
            ],
        ];

        foreach ($seed as $row){
            DB::table('images')->insert($row);
        }
    }
}
