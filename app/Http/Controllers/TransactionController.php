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
use Illuminate\Support\Facades\Log;


class TransactionController extends Controller
{
    public function index()
    {
        $transaksiData = DB::table('V_CURRENT_TRANSACTIONS')
        ->where('status_order', ['Memesan']) 
        ->whereNotNull('nomor_meja')
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
        'Method_Payment' => 'required',
        'Transaction_id' => 'required|exists:transactions,Transaction_id'
    ]);

    $transactionId = $validated['Transaction_id'];
    $methodPayment = $validated['Method_Payment'];
    $employeeId = Auth::user()->Employee_id;
    
    try {
        DB::statement('SET @current_employee_id = ?;', [$employeeId]); 
            DB::statement('CALL SP_CONFIRM_PAYMENT(?, ?, ?)', [
            $transactionId,
            $methodPayment,
            $employeeId, 
        ]);

        $transactionData = DB::table('transactions')
    ->join('orders', 'transactions.Order_id', '=', 'orders.Order_id')
    ->join('customers', 'orders.Customer_id', '=', 'customers.Customer_id')
    ->select(
        'transactions.*', 
        'transactions.Method_Payment', 
        'customers.No_Table',              
        'customers.Name AS CustomerName' 
    )
    ->where('transactions.Transaction_id', $transactionId)
    ->first();

    
    $itemDetails = DB::table('V_ITEM_DETAILS')
         ->where('Order_id', $transactionData->Order_id)
    ->get();
         return redirect()->route('transaksi.show', $transactionData->Transaction_id)->with('success', 'pembayaran berhasil');

    } catch (\Exception $e) {
        Log::error("Error saat konfirmasi pembayaran: " . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan pembayaran: ' . $e->getMessage());
    }
}

public function show($transaction_id)
{
     $transactionData = DB::table('transactions')
    ->join('orders', 'transactions.Order_id', '=', 'orders.Order_id')
    ->join('customers', 'orders.Customer_id', '=', 'customers.Customer_id')
    ->join('v_current_transactions', 'transactions.Order_id', '=', 'v_current_transactions.Order_id')
    ->select(
        'transactions.*', 
        'transactions.Method_Payment', 
        'customers.No_Table',          
        'v_current_transactions.total_harga_bersih', 
        'v_current_transactions.jumlah_pajak',   
        'customers.Name AS CustomerName' 
    )
    ->where('transactions.Transaction_id', $transaction_id)
    ->first();
    
    if (!$transactionData) {
        return redirect()->route('cashier.view')->with('error', 'Transaksi tidak ditemukan.');
    }
    
    $itemDetails = DB::table('v_item_details')
    ->where('Order_id', $transactionData->Order_id)
    ->get();
    
    $data = [
        'transaction' => $transactionData,
        'items' => $itemDetails,
    ];
    // dd($data);

    return view('transaksi.show', $data);
}

public function printStruk($transaction_id)
{   
    $transaction = DB::table('transactions') 
    ->join('v_current_transactions', 'transactions.Order_id', '=', 'v_current_transactions.Order_id')
    ->where('transactions.Transaction_id', $transaction_id)
    ->select('transactions.*', 'v_current_transactions.nama_pelayan','v_current_transactions.jumlah_pajak', 'v_current_transactions.total_harga_kotor','v_current_transactions.total_harga_bersih')
    ->first();
    // dd($transaction);
    $itemDetails = DB::table('v_item_details')
        ->where('Order_id', $transaction->Order_id)
        ->get();
    // dd($transaction);
  $data = [
        'transaction' => $transaction,
        'items'       => $itemDetails,
        'kasir'       => Auth::user()->name_employee, 
        'tanggal'     => \Carbon\Carbon::parse($transaction->Date)->format('d/m/Y H:i')
    ];
    $pdfFileName = 'Struk_T' . $transaction->Transaction_id . '.pdf';
    $pdf = Pdf::loadView('receipt.struk', $data);
    return $pdf->stream($pdfFileName);
}

}