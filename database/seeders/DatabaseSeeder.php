<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            MenuPartySeeder::class,
            MenuItemSeeder::class,
            CategorySeeder::class,
            MenuSeeder::class,
            TagSeeder::class,
            ImageSeeder::class,
            UserSeeder::class,
            PostSeeder::class,
            PostCategorySeeder::class,
            PostTagSeeder::class,
            RolesSeeder::class
        ]);
    }
}
