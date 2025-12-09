<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Menu;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Menampilkan menu dan keranjang aktif untuk meja tertentu.
     */
    public function index(Request $request, $No_Table)
    {
        $menus = Menu::all(); 
        
        $categoryFilter = $request->get('category', 'Semua');
        if ($categoryFilter !== 'Semua') {
            $menus = $menus->where('Category', $categoryFilter);
        }

        $activeOrder = Order::with('orderItems.menu')
                            ->where('No_Table', $No_Table)
                            ->where('Order_Status', 'memesan')
                            ->first();


        return view('menu', [
            'menus' => $menus,
            'No_Table' => $No_Table,
            'activeOrder' => $activeOrder,
        ]);
    }

    
    public function addToCart(Request $request, $No_Table,$Customer_id)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
        ]);

        $order = Order::firstOrCreate(
            ['table_No_Table' => $No_Table, 'status_pesanan' => 'memesan'],
            ['customer_id' => $Customer_id]
        );

        $orderItem = $order->orderItems()->where('menu_id', $request->menu_id)->first();

        if ($orderItem) {
            $orderItem->increment('quantity');
        } else {
            $order->orderItems()->create([
                'menu_id' => $request->menu_id,
                'quantity' => 1,
            ]);
        }

        return redirect()->back()->with('success', 'Item berhasil ditambahkan ke keranjang!');
    }
}