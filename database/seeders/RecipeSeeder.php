<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('recipies')->insert([
            'Name_Resep' => 'Soto Betawi Lada Hitam',
            'Keterangan' => 'Dimasak yah',
        ]);
        DB::table('recipies')->insert([
            'Name_Resep' => 'Ayam Pecak Joko Anwar',
            'Keterangan' => 'Dimasak yah',
        ]);
    }
}
