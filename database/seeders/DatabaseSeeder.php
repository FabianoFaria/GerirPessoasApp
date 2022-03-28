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
        // \App\Models\User::factory(10)->create();
    }
}

class UserTableSeeder extends Seeder {
 
    public function run()
    {
        DB::table('users')->delete();
 
        User::create(['name' => 'admin','email' => 'admin@bar.com', 'password' => '$2a$12$nTkA6erfkX8VhJ/NGk87s.BCm5Bh.gag6hXVBlJqAORy73PcvN.gm']);
        User::create(['name' => 'Ademir','email' => 'ademir@bar.com', 'password' => '$2a$12$nTkA6erfkX8VhJ/NGk87s.BCm5Bh.gag6hXVBlJqAORy73PcvN.gm']);

    }
 
}