<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $table = DB::table('tables')->where('No_Table', '1')->first();
        $tableId = $table->No_Table;
        $table2 = DB::table('tables')->where('No_Table', '2')->first();
        $tableId2 = $table2->No_Table;
        
         DB::table('customers')->insert([
            'Name'=>'Kylian Mbappe',
            'Phone_Number' => '082272118776',
            'No_Table' => $tableId,
            'created_at' => now(),
        ]);
         DB::table('customers')->insert([
            'Name'=>'Ethan Mbappe',
            'Phone_Number' => '081272118776',
            'No_Table' => $tableId2,
            'created_at' => now()
        ]);
    }
}
