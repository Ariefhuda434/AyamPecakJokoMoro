<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CashierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cashierRole = DB::table('roles')->where('slug', 'cashier')->first();
        $roleId = $cashierRole->role_id;
        DB::table('employees')->insert([
            'name_employee' => 'Bruno Fernandes',
            'number_phone' => '082272118774',
            'password' => Hash::make('password123'), 
            'role_id' => $roleId,
            'date_join' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
