<?php

namespace Database\Seeders;


use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class StrategiesSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('strategy')->insert([
            'name' => 'DESKTOP',
        ]);
        DB::table('strategy')->insert([
            'name' => 'MOBILE',
        ]);
    }
}