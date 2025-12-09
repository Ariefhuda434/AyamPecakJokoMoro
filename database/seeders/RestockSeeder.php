<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RestockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stockname = DB::table('stocks')->where('Name_Stock', 'Dada Ayam')->first();
        $stockId = $stockname->Stock_id;

         DB::table('restock_log')->insert([
            'Stock_id'=>$stockId,
            'Unit' => 'Potong',
            'Stock_Before' => '0',
            'Update_Quantity' => '50', 
            'Price' => '320000',
            'created_at' => now(),
        ]);
    }
}
