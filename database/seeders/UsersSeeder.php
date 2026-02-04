<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([[
            'name' => 'Diego',
            'email' => 'diego@gmail.com',
            'password' => Hash::make('123456'),
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'name' => 'Teste',
            'email' => 'teste@test.com',
            'password' => Hash::make('123456'),
            'created_at' => now(),
            'updated_at' => now(),
        ]]);
    }
}
