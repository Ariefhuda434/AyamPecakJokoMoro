<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Employee;
use App\Models\Transaction;
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
       $transaction = Transaction::create([
                'Employee_id' => $request->Employee_id,
                'Order_id' => $request->Order_id,
                'Total_Price' => $request->Total_Price
            ]);
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



public function paymentkonfirmasi(Request $request)
{
    $validated = $request->validate([
        'Method_Payment'  => 'required',
        'Transaction_id'  => 'required|exists:transactions,Transaction_id'
    ]);
    
    $transaksi = Transaction::findOrFail($validated['Transaction_id']);
    $orderId = $transaksi->Order_id;
    $employeeId = $transaksi->Employee_id ?? 'N/A'; 
    $currentTime = Carbon::now();

    $customerData = DB::table('orders')
                      ->join('customers', 'orders.Customer_id', '=', 'customers.Customer_id')
                      ->where('orders.Order_id', $orderId)
                      ->select('customers.Customer_id', 'customers.Name', 'customers.No_Table')
                      ->first();
    dd($customerData);
    if ($customerData) {
        $customerId = $customerData->Customer_id;
        $customerName = $customerData->Name;
        $tableNumber = $customerData->No_Table;

        DB::table('audit_logs')->insert([
            'Table_Name' => 'customers',
            'Record_ID' => $customerId,
            'Action_Typn' => 'DELETE',
            'Column_Name' => 'Name', 
            'Old_Value' => 'Pelanggan: ' . $customerName . ' (Meja ' . $tableNumber . ')',
            'New_Value' => null,
            'Employee_id' => $employeeId,
            'Change_time' => $currentTime,
        ]);

        $oldTableStatus = DB::table('tables')->where('No_Table', $tableNumber)->value('Status');
        
        DB::table('tables')
            ->where('No_Table', $tableNumber)
            ->update(['Status' => 'Available']); 
        
        DB::table('audit_logs')->insert([
            'Table_Name' => 'tables',
            'Record_ID' => $tableNumber,
            'Action_Typn' => 'UPDATE',
            'Column_Name' => 'Status',
            'Old_Value' => $oldTableStatus,
            'New_Value' => 'Available',
            'Employee_id' => $employeeId,
            'Change_time' => $currentTime,
        ]);

        DB::table('customers')->where('Customer_id', $customerId)->delete();
    }


    $oldOrderStatus = DB::table('orders')->where('Order_id', $orderId)->value('Order_Status');
    
    DB::table('orders')
        ->where('Order_id', $orderId)
        ->update(['Order_Status' => 'Lunas']);
    
    DB::table('audit_logs')->insert([
        'Table_Name' => 'orders',
        'Record_ID' => $orderId,
        'Action_Typn' => 'UPDATE',
        'Column_Name' => 'Order_Status',
        'Old_Value' => $oldOrderStatus,
        'New_Value' => 'Lunas',
        'Employee_id' => $employeeId,
        'Change_time' => $currentTime,
    ]);


    $transaksi->update([
        'Method_Payment' => $validated['Method_Payment'], 
        'Status' => 'Paid', 
        'Date' => $currentTime, 
    ]);

    DB::table('audit_logs')->insert([
        'Table_Name' => 'transactions',
        'Record_ID' => $transaksi->Transaction_id,
        'Action_Typn' => 'UPDATE',
        'Column_Name' => 'Status/Method_Payment', 
        'Old_Value' => 'Pending',
        'New_Value' => 'Paid (' . $validated['Method_Payment'] . ')',
        'Employee_id' => $employeeId,
        'Change_time' => $currentTime,
    ]);
    return redirect()->route('cashier.view')->with('success', 'Transaksi selesai. Meja sudah dikosongkan dan data pelanggan dibersihkan.');
}
}