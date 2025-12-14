<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $transaksiData = DB::table('V_CURRENT_TRANSACTIONS')
        ->where('status_order', ['Memesan']) 
        ->get();
        if ($transaksiData->isEmpty()) {
            return view('transaksi', [
                'transaksiData' => $transaksiData,
                'transaksiDetails' => collect([]), 
            ]);
        }   

        $orderIds = $transaksiData->pluck('Order_id')->toArray();

        $detailPesanan = DB::table('V_ITEM_DETAILS')
        ->whereIn('Order_id', $orderIds)
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

    public function payment(Request $request)
    {
       $request->validate([
            'Employee_id' => 'required|exists:employees,Employee_id',
            'Order_id' => 'required|exists:orders,Order_id',
            'Total_Price' => 'required|numeric',
        ]);
       $transaction = Transaction::create([
                'Employee_id' => $request->Employee_id,
                'Order_id' => $request->Order_id,
                'Total_Price' => $request->Total_Price
            ]);
           $orderId = $request->Order_id;

        $orderUtama = DB::table('V_CURRENT_TRANSACTIONS')
        ->where('Order_id', $orderId) 
        ->first();

   $dataItemDetail =  DB::table('V_ITEM_DETAILS') 
    ->where('Order_id', $orderId) 
    ->get();

    return view('payment.payment', [
        'order' => $orderUtama,
        'items' => $dataItemDetail,
        'transaction' => $transaction
    ])->with('message', 'Silakan lanjutkan pembayaran.');
}

public function paymentkonfirmasi(Request $request)
{
    $validated = $request->validate([
        'Method_Payment'  => 'required',
        'Transaction_id'  => 'required|exists:transactions,Transaction_id'
    ]);
    $transactionId = $validated['Transaction_id'];
    $methodPayment = $validated['Method_Payment'];
    $employeeId = Auth::id();
    DB::statement('CALL SP_CONFIRM_PAYMENT(?, ?, ?)', [
            $transactionId,
            $methodPayment,
            $employeeId,
        ]);
    return redirect()->route('cashier.view')->with('success', 'Transaksi selesai. Proses data ditangani oleh Stored Procedure.');
}

public function printStruk($order_id)
{
    // 1. Ambil data Order utama dari view/tabel (Order_Status pasti sudah Lunas/Selesai)
    $order = DB::table('V_CURRENT_TRANSACTIONS')
        ->where('Order_id', $order_id)
        ->first(); // Menggunakan view untuk detail order

    // Fallback jika tidak ditemukan di view transaksi aktif (karena sudah lunas/selesai)
    if (!$order) {
        $order = DB::table('orders')
                    ->select('orders.*', 'customers.Name as nama_customer', 'tables.No_Table as nomor_meja')
                    ->join('customers', 'customers.Customer_id', '=', 'orders.Customer_id')
                    ->join('tables', 'tables.No_Table', '=', 'customers.No_Table')
                    ->where('orders.Order_id', $order_id)
                    ->first();
    }

    if (!$order) {
        return redirect()->back()->with('error', 'Data order tidak ditemukan.');
    }

    // 2. Ambil detail pesanan (items)
    $dataItemDetail = DB::table('V_ITEM_DETAILS')
        ->where('Order_id', $order_id)
        ->get();
    
    $transactionData = DB::table('transactions')
        ->where('Order_id', $order_id)
        ->latest('Transaction_id') // Ambil transaksi terakhir jika ada beberapa
        ->first();
        
    if (!$transactionData) {
        return redirect()->back()->with('error', 'Data pembayaran (transaction) belum tercatat.');
    }

    $data = [
        'order' => $order,
        'items' => $dataItemDetail,
        'transaction' => $transactionData,
        'paidAmount' => $transactionData->Total_Price ?? $order->Total,
        'namaKasir' => Employee::find($transactionData->Employee_id)->Name_Employee ?? 'N/A',
        'namaPelayan' => Employee::find($order->Employee_id)->Name_Employee ?? 'N/A', 
        'paymentMethod' => $transactionData->Method_Payment ?? 'TUNAI',
    ];

    $pdfFileName = 'struk_meja_' . ($order->nomor_meja ?? 'TAKEAWAY') . '_order_' . $order_id . '.pdf';

    $pdf = Pdf::loadView('struk.template', $data);

    return $pdf->stream($pdfFileName);
}
}