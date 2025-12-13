<?php
namespace Database\Seeders;
// database/seeders/RoleSeeder.php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run()
    {
        DB::table('roles')->insert([
            ['role_name' => 'Manajer', 'slug' => 'manager', 'created_at' => now(), 'updated_at' => now()],
            ['role_name' => 'Kasir', 'slug' => 'cashier', 'created_at' => now(), 'updated_at' => now()],
            ['role_name' => 'Pelayan', 'slug' => 'waiter', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}