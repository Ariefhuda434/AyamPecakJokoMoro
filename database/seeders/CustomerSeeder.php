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
         DB::table('customers')->insert([
            'Name'=>'Kylian Mbappe',
            'Phone_Number' => '082272118776',
            'created_at' => now(),
        ]);
         DB::table('customers')->insert([
            'Name'=>'Ethan Mbappe',
            'Phone_Number' => '081272118776',
            'created_at' => now()
        ]);
    }
}
