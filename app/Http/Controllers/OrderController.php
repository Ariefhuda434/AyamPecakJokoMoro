<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Stock; 
use App\Models\Recipe; // Pastikan ini di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf; 

class OrderController extends Controller
{
public function index(Request $request, $No_Table, $Customer_id)
{
    
    $menuQuery = Menu::query(); 
    
    $categoryFilter = $request->get('category', 'Semua');
    
    if ($categoryFilter !== 'Semua') {
        $menuQuery->where('Category', $categoryFilter);
    }
    
    $menus = $menuQuery->get(); 

    
    $employee = Auth::user(); 
    $employeeId = $employee->Employee_id;

    $activeOrder = Order::where('Customer_id', $Customer_id)
        ->whereNotIn('Order_Status', ['Selesai', 'Lunas', 'Batal']) 
        ->with('orderDetails.menu')
        ->latest('Order_id') 
        ->first();

    $totalmenu = Menu::count();
    $MenuMakanan = Menu::where('Category', 'Makanan')->count();
    $MenuMinuman = Menu::where('Category', 'Minuman')->count();
    $MenuCemilan = Menu::where('Category', 'Cemilan')->count();

    return view('menu', [
        'menus' => $menus, 
        'No_Table' => $No_Table,
        'sessionCart' => session()->get('cart', []),
        'activeOrder' => $activeOrder,
        'employeeId' => $employeeId,
        'customerId' => $Customer_id,
        'categoryFilter' => $categoryFilter, 
        'totalmenu' => $totalmenu,
        'MenuMakanan' => $MenuMakanan,
        'MenuMinuman' => $MenuMinuman,
        'MenuCemilan' => $MenuCemilan,
    ]);
}

    public function destroyCart($menu_id){
        $cart = session()->get('cart', []);

    if (isset($cart[$menu_id])) {
        unset($cart[$menu_id]);
        session()->put('cart', $cart);
        return back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }

    return back()->with('error', 'Item tidak ditemukan di keranjang.');
    }
    public function addToCart(Request $request)
    {
        $request->validate(['Menu_id' => 'required|exists:menus,Menu_id', 'Quantity' => 'required|integer|min:1']);
        
        $menu = Menu::find($request->Menu_id);
        $quantity = $request->Quantity;
        
        $cart = session()->get('cart', []);
        $itemId = $menu->Menu_id; 
        
        if(isset($cart[$itemId])) {
            $cart[$itemId]['Quantity'] += $quantity;
        } else {
            $cart[$itemId] = [
                "Menu_id" => $menu->Menu_id,
                "Name" => $menu->Name,
                "Quantity" => $quantity,
                "Price" => $menu-> Price, 
                "Notes" => $request->Notes ?? '', 
            ];
        }
        session()->put('cart', $cart);

        return redirect()->back()->with('success', $menu->Name . ' berhasil ditambahkan ke pesanan.');
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart');
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Pesanan masih kosong.');
        }
        
        $request->validate([
            'Employee_id' => 'required|exists:employees,Employee_id',
            'Customer_id' => 'required|exists:customers,Customer_id',
        ]);
        
        $totalPrice = array_sum(array_map(function($item) {
            return $item['Price'] * $item['Quantity'];
        }, $cart));
        
        DB::beginTransaction();
        try {
            $employeeId = $request->Employee_id;
            $customerId = $request->Customer_id;
            $orderId = 0; 
            DB::statement('CALL SP_CreateOrder (?, ?, ?, @order_id)', [
                $employeeId,
                $customerId,
                $totalPrice,
            ]);

            $result = DB::select('SELECT @order_id AS Order_id');
            $orderId = $result[0]->Order_id;

            if (!$orderId) {
                throw new \Exception('Gagal mendapatkan Order ID.');
            }

            foreach ($cart as $item) {
               
                DB::statement('CALL SP_ProcessOrderItem (?, ?, ?, ?, ?, @success, @error_message)', [
                    $orderId,
                    $item['Menu_id'],
                    $item['Quantity'],
                    $item['Price'],
                    $item['Notes'],
                ]);

                $result = DB::select('SELECT @success AS success, @error_message AS error_message');
                $success = $result[0]->success;
                $errorMessage = $result[0]->error_message;

                if (!$success) {
                    throw new \Exception($errorMessage);
                }
            }
        
            session()->forget('cart');
            DB::commit();
            

            return redirect()->route('order.show', $orderId)->with('success', 'Order berhasil dibuat dan stok diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan order: ' . $e->getMessage());
        }
    }

// ... (Bagian bawah controller tetap sama)
    public function show($order_id)
    {
        $order = Order::with(['customer.table', 'employee', 'orderDetails.menu'])
        ->findOrFail($order_id);
                      
        return view('order.show', compact('order'));
    }

    public function printStruk($order_id)
    {
        $order = Order::with(['customer.table', 'employee', 'orderDetails.menu'])
                      ->findOrFail($order_id);
        
        $tableName = $order->customer->table->No_Table ?? 'TAKEAWAY';
        $pdfFileName = 'kot_meja_' . $tableName . '_order_' . $order_id . '.pdf';

        $pdf = Pdf::loadView('struk.template', compact('order'));

        return $pdf->stream($pdfFileName); 
    }
}