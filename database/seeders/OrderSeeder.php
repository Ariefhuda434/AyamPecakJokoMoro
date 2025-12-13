<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use function Symfony\Component\Clock\now;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customerName = DB::table('customers')->where('Name', 'Kylian Mbappe')->first();
        $customerId = $customerName->Customer_id;

        $EmployeeName = DB::table('employees')->where('name_employee', 'Kobie Mainoo')->first();
        $EmployeeId = $EmployeeName->Employee_id;
   

         DB::table('orders')->insert([
            'Customer_id'=>$customerId,
            'Employee_id'=>$EmployeeId,
            'Order_Status' => 'Belum Memesan',
            'Total' => '200000',    
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
