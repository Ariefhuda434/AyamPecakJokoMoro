<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $managerRole = DB::table('roles')->where('slug', 'manager')->first();
        $roleId = $managerRole->role_id;
        DB::table('employees')->insert([
            'name_employee' => 'Joko Moro Manager',
            'number_phone' => 'manager@jokomoro.com',
            'password' => Hash::make('password123'), 
            'role_id' => $roleId,
            'date_join' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
