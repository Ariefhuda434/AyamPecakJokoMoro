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
        // dd($cart);
        
        DB::beginTransaction();
        try {
            foreach ($cart as $item) {
                
                $menu = Menu::with('recipe.stocksMagic')->find($item['Menu_id']);
                if (!$menu || !$menu->recipe || $menu->recipe->stocksMagic->isEmpty()) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Resep atau bahan baku untuk menu ' . $menu->Name . ' tidak ditemukan/belum didaftarkan.');
                }   
                foreach ($menu->recipe->stocksMagic as $stock) {    
                    $quantityNeeded = $stock->pivot->Quantity; 
                    $quantityUsed = $quantityNeeded * $item['Quantity']; 
                    if ($stock->Current_Stock < $quantityUsed) {
                        DB::rollBack();
                        return redirect()->back()->with('error', 'Stok ' . $stock->Name . ' tidak cukup (' . $stock->Current_Quantity . ' tersedia) untuk pesanan ini.');
                    }

                    $stock->Current_Stock -= $quantityUsed;
                    $stock->save(); 
                }
            }
            
            $order = Order::create([
                'Employee_id' => $request->Employee_id,
                'Customer_id' => $request->Customer_id,
                'Total' => $totalPrice,
                'Order_Status' => 'Memesan', 
            ]);
            
            foreach ($cart as $item) {
                $itemSubtotal = $item['Price'] * $item['Quantity'];
                
                OrderDetail::create([
                    'Order_id' => $order->Order_id,
                    'Menu_id' => $item['Menu_id'],
                    'Quantity' => $item['Quantity'],
                    'Subtotal' => $itemSubtotal, 
                    'Notes' => $item['Notes'],
                ]);
            }

            session()->forget('cart');
            DB::commit();
            
            return redirect()->route('order.show', $order->Order_id)->with('success', 'Order berhasil dibuat dan stok diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan order: ' . $e->getMessage());
        }
    }
    
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