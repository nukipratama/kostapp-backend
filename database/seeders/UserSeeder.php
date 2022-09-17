<?php

namespace Database\Seeders;

use App\Models\UsersRole;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = Role::all();
        $users = [[
            'name' => 'Owner KostApp',
            'email' => 'owner@kostapp.dev',
            'role_id' => $roles->where('prefix', 'owner')->first()->id
        ], [
            'name' => 'Regular User KostApp',
            'email' => 'regular@kostapp.dev',
            'role_id' => $roles->where('prefix', 'regular_user')->first()->id
        ], [
            'name' => 'Premium User KostApp',
            'email' => 'premium@kostapp.dev',
            'role_id' => $roles->where('prefix', 'premium_user')->first()->id
        ]];

        foreach ($users as $each) {
            $user = User::create([
                'name' => $each['name'],
                'email' => $each['email'],
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
            ]);
            $user->role()->create(['role_id' => $each['role_id']]);
            $user->credit()->create();
        }
    }
}
