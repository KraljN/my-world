<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create(['name' => 'admin']);
        $user = Role::create(['name' => 'user']);
        $writer = Role::create(['name' => 'writer']);

        $userAdmin = User::find(1);
        $userWriter = User::find(2);

        $userAdmin->assignRole($admin);
        $userWriter->assignRole($writer);
    }
}
