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
        $userData = [
            'id' => 1,
            'name' => 'Admin',
            'username' => 'admin',
            'phone' => '012345678910',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('pastibisa')
        ];

        DB::table('users')->insert($userData);
    }
}
