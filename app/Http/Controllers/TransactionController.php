<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
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
                'employees.Name_Employee as nama_pelayan',
                'orders.Order_Status as status_order',
                'orders.Total as total_harga',
                
            ])
            ->orderBy('orders.created_at', 'desc')
            ->get();

        if ($transaksiData->isEmpty()) {
            return view('transaksi', [
                'transaksiData' => $transaksiData,
                'transaksiDetails' => collect([]), 
            ]);
        }   

        $orderIds = $transaksiData->pluck('Order_id')->toArray();

        $detailPesanan = DB::table('detail_order')
            ->join('menus', 'menus.Menu_id', '=', 'detail_order.Menu_id')
            ->whereIn('detail_order.Order_id', $orderIds)
            ->select([
                'detail_order.Order_id', 
                'menus.Name as nama_menu',
                'detail_order.Quantity as jumlah_pesanan',
                'menus.Price as harga_satuan', 
                'detail_order.Notes as catatan',
            ])
            ->get();
        
       $transactionsWithDetails = $transaksiData->map(function ($transaction) use ($detailPesanan) {
    $transaction->items = $detailPesanan
                            ->where('Order_id', $transaction->Order_id)
                            ->values()
                            ->toArray();
    return $transaction;
});

        return view('transaksi', [
            'transaksiData' => $transactionsWithDetails, 
        ]);
    }
}