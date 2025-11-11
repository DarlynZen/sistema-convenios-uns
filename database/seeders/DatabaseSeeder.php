<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        // User::factory(10)->create();

        if (!User::where('email', 'dctia@uns.edu.pe')->exists()) {
            User::factory()->create([
                'name' => 'Usuario DCTIA',
                'email' => 'dctia@uns.edu.pe',
                'password' => bcrypt('123'),
            ]);
        }
    }
}
