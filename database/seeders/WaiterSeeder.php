<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class WaiterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $waiterRole = DB::table('roles')->where('slug', 'waiter')->first();
        $roleId = $waiterRole->role_id;
        DB::table('employees')->insert([
            'name_employee' => 'Kobie Mainoo',
            'number_phone' => '082272118779',
            'password' => Hash::make('password123'), 
            'role_id' => $roleId,
            'date_join' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
