<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(){
        $transaksiData = DB::table('orders')
    ->join('customers', 'customers.Customer_id', '=', 'orders.Customer_id')
    ->join('employees', 'employees.Employee_id', '=', 'orders.Employee_id')
    ->join('tables', 'tables.No_Table', '=', 'customers.No_Table')
    ->whereNotIn('orders.Order_Status', ['Selesai', 'Lunas', 'Batal']) 
    ->select([
        'orders.Order_id',
        'tables.No_Table as nomor_meja',
        'customers.Name as nama_customer',
        'customers.Phone_Number as nomor_hp',
        'orders.Order_Status as status_order',
        'tables.status_table as status_meja', 
        'employees.Name_Employee as nama_pelayan',
        'orders.Total as total_harga',
        'orders.created_at',
    ])
    ->orderBy('orders.created_at', 'desc')
    ->get();
        return view('transaksi',[
            'transaksiData' => $transaksiData

        ]);
    }
}
