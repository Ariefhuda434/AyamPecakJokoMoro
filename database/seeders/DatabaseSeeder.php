<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            RoleSeeder::class,
            WaiterSeeder::class,
            ManagerSeeder::class,
            CashierSeeder::class,
            StockSeeder::class,
            RestockSeeder::class,
            TableSeeder::class,
            CustomerSeeder::class,
            OrderSeeder::class,
    ]);
    }
}
