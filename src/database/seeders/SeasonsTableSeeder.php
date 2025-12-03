<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeasonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seasons = [
            '春',
            '夏',
            '秋',
            '冬'
        ];

        foreach ($seasons as $season) {
            DB::table('seasons')->insert([
                'name' => $season,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}