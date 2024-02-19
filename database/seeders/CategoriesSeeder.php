<?php

namespace Database\Seeders;


use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('category')->insert([
            'name' => 'ACCESSIBILITY',
        ]);
        DB::table('category')->insert([
            'name' => 'BEST_PRACTICES',
        ]);
        DB::table('category')->insert([
            'name' => 'PERFORMANCE',
        ]);
        DB::table('category')->insert([
            'name' => 'PWA',
        ]);
        DB::table('category')->insert([
            'name' => 'SEO',
        ]);
    }
}