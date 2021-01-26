<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
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
        Department::factory(10)->create();
        User::factory(10)->create();
        $this->call([
            RolesSeeder::class,
            ModelHasRolesSeeder::class
        ]);

    }
}
