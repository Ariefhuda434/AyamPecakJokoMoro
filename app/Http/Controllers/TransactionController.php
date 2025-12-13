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

    //fungsi bayar
 public function payment(Request $request)
    {
        $request->validate([
            'Employee_id' => 'required|exists:employees,Employee_id', 
            'Order_id' => 'required|exists:orders,Order_id',
            'Total_Price' => 'required|numeric', 
        ]);

        $orderId = $request->Order_id;

        
        $transaction = Transaction::firstOrNew(['Order_id' => $orderId]);
        
        $transaction->Employee_id = $request->Employee_id; 
        $transaction->Total_Price = $request->Total_Price;
        $transaction->save(); 
        
        
        $orderUtama = DB::table('orders') 
            ->join('customers', 'orders.Customer_id', '=', 'customers.Customer_id')
            ->join('tables', 'customers.No_Table', '=', 'tables.No_Table') 
            ->where('orders.Order_id', $orderId) 
            ->select([
                'orders.Order_id',
                'orders.Total as total_harga', 
                'orders.Employee_id', 
                'tables.No_Table as nomor_meja',
                'customers.Name as nama_pembeli',
                'customers.Customer_id',
            ])
            ->first(); 
        
        if (!$orderUtama) {
            return redirect()->back()->with('error', 'Order tidak ditemukan atau tidak lengkap.');
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

       
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production', false);
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
        
        $itemDetails = [];
        foreach ($dataItemDetail as $item) {
            $itemDetails[] = [
                'id' => $item->nama_menu, 
                'price' => (int) $item->harga_satuan,
                'quantity' => (int) $item->jumlah_pesanan,
                'name' => $item->nama_menu,
            ];
        }

        $params = array(
            'transaction_details' => array(
                'order_id' => 'TRX-' . $transaction->Transaction_id . '-' . time(), 
                'gross_amount' => (int) $transaction->Total_Price, 
            ),
            'item_details' => $itemDetails, 

            'customer_details' => array(
                'first_name' => $orderUtama->nama_pembeli, 
            ),
        );
        
        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $transaction->snap_token = $snapToken;
            $transaction->save();

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membuat token pembayaran Midtrans: ' . $e->getMessage());
        }

        return view('payment.payment', [
            'order' => $orderUtama,
            'items' => $dataItemDetail,
            'transaction' => $transaction
        ])->with('message', 'Silakan lanjutkan pembayaran.');
    }

public function paymentStatus(Request $request)
{
    $request->validate([
        'transaction_id' => 'required|exists:transactions,Transaction_id',
        'status' => 'required|string|in:success,pending,failure',
    ]);

    $transactionId = $request->transaction_id;
    $statusDariSnap = $request->status;

    $transaction = Transaction::with('order.customer', 'order.employee')
                    ->where('Transaction_id', $transactionId)
                    ->first();

    if (!$transaction) {
        return redirect()->route('cashier.dashboard')->with('error', 'Transaksi lokal tidak ditemukan.');
    }
    
    $statusText = '';
    $statusColor = '';

    switch ($statusDariSnap) {
        case 'success':
            $statusText = 'Pembayaran Berhasil Diterima.';
            $statusColor = 'green';
            break;
        case 'pending':
            $statusText = 'Menunggu Pembayaran (Pending).';
            $statusColor = 'yellow';
            break;
        case 'failure':
            $statusText = 'Pembayaran Dibatalkan/Gagal.';
            $statusColor = 'red';
            break;
    }

    return view('payment.status', [
        'transaction' => $transaction,
        'statusText' => $statusText,
        'statusColor' => $statusColor,
        'snapStatus' => $statusDariSnap,
    ]);
}
}