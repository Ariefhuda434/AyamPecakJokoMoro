<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class StockController extends Controller
{
  public function index()
{
    $stockData = DB::table('view_stock_restock')
        ->orderBy('tanggal_restock_terakhir', 'desc') 
        ->get();

    return view('stock', compact('stockData'));
}
public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'Name_Stock' => 'required|string|max:150', 
                'Unit' => 'required|string|max:50',
                'Min_Stock_Level' => 'required|numeric|min:1'
            ]);
      
            $query = "CALL SP_CreateStock(?, ?, ?)";

            DB::statement($query, [
                $validated['Name_Stock'],
                $validated['Unit'],
                $validated['Min_Stock_Level']
            ]);  
            return Redirect()->route('stock.index')->with('success', 'Stok berhasil ditambahkan');

        } catch (\Exception $e) {
            return Redirect()->back()->withInput()->with('error', 'Gagal menambahkan stok. Transaksi Dibatalkan');
        }
    }

    public function update(Request $request, Stock $stock)
    {

            $validated = $request->validate([
                'Name_Stock' => 'required|string|max:150',
                'Unit' => 'required|string|max:50',
                'Min_Stock_Level' => 'required|numeric|min:1' 
            ]);
            
            $currentEmployeeId = Auth::user()->Employee_id;

            DB::statement("SET @current_employee_id = ?", [$currentEmployeeId]);

            //trigger akan otomatis dipanggil jika data stock diubah
            $stock->update($validated);
            return Redirect()->route('stock.index')->with('success', 'Stok berhasil diupdate');
    }

    public function destroy(Stock $stock)
    {
            $currentEmployeeId = Auth::user()->Employee_id;
            DB::statement("SET @current_employee_id = ?", [$currentEmployeeId]);
            //trigger akan otomatis dipanggil jika data stock dihapus
            $stock->delete();
            return Redirect()->route('stock.index')->with('success', 'Stok berhasil dihapus');
    }
}
