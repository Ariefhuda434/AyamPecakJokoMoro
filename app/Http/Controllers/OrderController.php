<?php

    namespace App\Http\Controllers;

    use App\Models\Menu;
    use App\Models\Order;
    use App\Models\Customer;
    use App\Models\OrderDetail;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Auth;

    class OrderController extends Controller
    {
        /**
         * Menampilkan menu dan keranjang aktif untuk meja tertentu.
         */
        public function index(Request $request, $No_Table,$Customer_id)
        {
            $menus = Menu::all(); 
            $employee = Auth::user(); 
            $employeeId = $employee->Employee_id;

            $categoryFilter = $request->get('category', 'Semua');
            if ($categoryFilter !== 'Semua') {
                $menus = $menus->where('Category', $categoryFilter);
            }

            $activeOrder = Order::where('Customer_id', $Customer_id)
        ->whereNotIn('Order_Status', ['Selesai', 'Batal']) 
        ->with('orderDetails.menu')
        ->latest('Order_id') 
        ->first();
            $sessionCart = session()->get('cart', []);
            return view('menu', [
                'menus' => $menus,
                'No_Table' => $No_Table,
                'sessionCart' => $sessionCart,
                'activeOrder' => $activeOrder,
                'employeeId' => $employeeId,
                'customerId' => $Customer_id
            ]);
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

        return redirect()->back()->with('success', $menu->name . ' berhasil ditambahkan ke pesanan.');
    }
    public function checkout(Request $request)
    {
        $cart = session()->get('cart');
        if (empty($cart)) {
            return redirect()->route('order.index')->with('error', 'Pesanan masih kosong.');
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
            $order = Order::create([
                'Employee_id' => $request->Employee_id,
                'Customer_id' => $request->Customer_id,
                'Total' => $totalPrice,
                'Order_Status' => 'Memesan', 
            ]);

            foreach ($cart as $item) {
                OrderDetail::create([
                    'Order_id' => $order->Order_id,
                    'Menu_id' => $item['Menu_id'],
                    'Quantity' => $item['Quantity'],
                    'Subtotal' => $totalPrice,
                    'Notes' => $item['Notes'],
                ]);
            }

            session()->forget('cart');
            DB::commit();
            return redirect()->route('order.index', $order->Order_id)->with('success', 'Order berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan order: ' . $e->getMessage());
        }
    }

    }