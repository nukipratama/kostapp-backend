<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                "title" => 'Owner',
                "prefix" => 'owner'
            ],
            [
                "title" => 'Regular User',
                "prefix" => 'regular_user'
            ],
            [
                "title" => 'Premium User',
                "prefix" => 'premium_user'
            ]
        ];
        foreach ($roles as $each) {
            Role::firstOrCreate([
                "title" => $each['title'],
                "prefix" => $each['prefix'],
            ]);
        }
    }
}
