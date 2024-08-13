<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $divisionData = [
            [
                'id' => 1,
                'name' => 'Mobile Apps'
            ],
            [
                'id' => 2,
                'name' => 'QA'
            ],
            [
                'id' => 3,
                'name' => 'Full Stack'
            ],
            [
                'id' => 4,
                'name' => 'Backend'
            ],
            [
                'id' => 5,
                'name' => 'Front End'
            ],
            [
                'id' => 6,
                'name' => 'UI/UX Designer'
            ]
        ];

        DB::table('divisions')->insert($divisionData);
    }
}
