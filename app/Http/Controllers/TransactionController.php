<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PSpell\Config;

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
                'employees.Employee_id',
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
    public function payment(Request $request){
       $request->validate([
            'Employee_id' => 'required|exists:employees,Employee_id',
            'Order_id' => 'required|exists:orders,Order_id',
            'Total_Price' => 'required|numeric',
        ]);
        // dd($validated);
       $transaction = Transaction::create([
                'Employee_id' => $request->Employee_id,
                'Order_id' => $request->Order_id,
                'Total_Price' => $request->Total_Price
            ]);

\Midtrans\Config::$serverKey = config('midtrans.server_key');
// dd(\Midtrans\Config::$serverKey);
\Midtrans\Config::$isProduction = config('midtrans.is_production', false);

\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;

$params = array(
            'transaction_details' => array(
            'order_id' => 'TRX-' . $transaction->Transaction_id . '-' . time(), 
            'gross_amount' => $transaction->Total_Price, 
            ),
        );
$snapToken = \Midtrans\Snap::getSnapToken($params);
$transaction ->snap_token = $snapToken;
$transaction ->save();
           $orderId = $request->Order_id;

    $orderUtama = DB::table('orders') 
        ->join('customers', 'orders.Customer_id', '=', 'customers.Customer_id')
        ->join('tables', 'customers.No_Table', '=', 'tables.No_Table') 
        ->where('orders.Order_id', $orderId) 
        ->select([
            'orders.Order_id',
            'orders.Total', 
            'orders.Employee_id', 
            'tables.No_Table as nomor_meja',
            'customers.Name as nama_pembeli',
            'customers.Customer_id',
        ])
        ->first(); 

    if (!$orderUtama) {
        return redirect()->back()->with('error', 'Order tidak ditemukan.');
    }

    $dataItemDetail = DB::table('detail_order')
        ->join('menus', 'menus.Menu_id', '=', 'detail_order.Menu_id')
        ->where('detail_order.Order_id', $orderId)
        ->select([
            'menus.Name as nama_menu',
            'detail_order.Quantity as jumlah_pesanan',
            'menus.Price as harga_satuan', 
            'detail_order.Notes as catatan',
            DB::raw('detail_order.Quantity * menus.Price as subtotal') 
        ])
        ->get();

    return view('payment.payment', [
        'order' => $orderUtama,
        'items' => $dataItemDetail,
        'transaction' => $transaction
    ])->with('message', 'Silakan lanjutkan pembayaran.');
}
}