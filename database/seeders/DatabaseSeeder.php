<?php

namespace Database\Seeders;

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
        // seed roles
        $this->call(RoleSeeder::class);
        $this->command->info('Roles seeded!');
        // seed users and users_role
        $this->call(UserSeeder::class);
        $this->command->info('Users seeded!');
        // seed kosts
        $this->call(KostSeeder::class);
        $this->command->info('Kosts seeded!');
    }
}
