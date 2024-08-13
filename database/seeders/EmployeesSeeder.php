<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employeeData = [
            'id' => 1,
            'image' => 'profile.jpeg',
            'name' => 'Muhammad Aqilul Muttaqin',
            'phone' => '082339550714',
            'division_id' => 3,
            'position' => 'Intern'
        ];

        DB::table('employees')->insert($employeeData);
    }
}
