<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::create([
            "name" => "admin",
            "email" => "admin@mail.com",
            "password" => bcrypt("password"),
        ]);

        // uncomment this if you need to seed the database (for testing purpose)
        // $this->call([
        //     MemberSeeder::class
        // ]);
    }
}
