<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            DB::beginTransaction();

            $validated = $request->validate([
                'Name_Stock' => 'required|string|max:150', 
                'Unit' => 'required|string|max:50',
                'Min_Stock_Level' => 'required|numeric|min:1'
            ]);

            $StockData = [
                'Name_Stock' => $validated['Name_Stock'],
                'Unit' => $validated['Unit'],
                'Min_Stock_Level' => $validated['Min_Stock_Level'],
                'created_at' => now()
            ];

            Stock::create($StockData);

            DB::commit();

            return Redirect()->route('stock.index')->with('success', 'Stok berhasil ditambahkan');

        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect()->back()->withInput()->with('error', 'Gagal menambahkan stok. Transaksi dibatalkan.');
        }
    }

    public function update(Request $request, Stock $stock)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'Name_Stock' => 'required|string|max:150',
                'Unit' => 'required|string|max:50',
                'Min_Stock_Level' => 'required|numeric|min:1' 
            ]);

            $stock->update($validated);

            DB::commit();

            return Redirect()->route('stock.index')->with('success', 'Stok berhasil diupdate');

        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect()->back()->withInput()->with('error', 'Gagal mengupdate stok. Transaksi dibatalkan.');
        }
    }

    public function destroy(Stock $stock)
    {
        try {
            DB::beginTransaction();

            $stock->delete();

            DB::commit();

            return Redirect()->route('stock.index')->with('success', 'Stok berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect()->route('stock.index')->with('error', 'Gagal menghapus stok. Transaksi dibatalkan atau stok terkait dengan data lain.');
        }
    }
}
