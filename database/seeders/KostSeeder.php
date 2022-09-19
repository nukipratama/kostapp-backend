<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kost;
use Illuminate\Database\Seeder;

class KostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'owner@kostapp.dev')->first();
        if ($user) {
            Kost::factory(5)->create(['user_id' => $user->id]);
        }
    }
}
