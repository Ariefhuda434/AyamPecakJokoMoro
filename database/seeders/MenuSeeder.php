<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $recipe = DB::table('recipies')->where('Name', 'Soto Betawi Lada Hitam')->first();
        $recipeId = $recipe->Recipe_id;
        
        DB::table('menus')->insert([
            'Recipe_id'=>$recipeId,
            'Category' => 'Makanan',
            'Name' => 'Soto Betawi',
            'Price' => '320000',
            'slug' => Str::slug('Soto Betawi'),
            'Menu_Status' => 'Tersedia',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
