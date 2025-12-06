<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('stocks')->insert([
            'Name_Stock' => 'Dada Ayam',
            'Unit' => 'Potong',
            'Current_Stock' => '12', 
            'min_stock_level' => '5',
            'Last_Cost' => '300.000',
            'updated_at' => now(),
        ]);
    }
}
