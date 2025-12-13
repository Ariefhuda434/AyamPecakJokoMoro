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
public function store(Request $request){
   $validated = $request->validate([
    'Name_Stock' => 'required|string|max:150', 
     'Unit'=>'required|string|max:50',
    'Min_Stock_Level'=>'required|numeric|min:1'
]);

$StockData = [
  'Name_Stock'=>$validated['Name_Stock'],
  'Unit'=>$validated['Unit'],
  'Min_Stock_Level'=> $validated['Min_Stock_Level'],
  'created_at' => now()
];
// dd($StockData);
        Stock::create($StockData);
        return Redirect()->route('stock.index')->with('succes','stok berhasil ditambahkan');
    }
    public function update(Request $request,Stock $stock){
        $validated = $request->validate([
            'Name_Stock'=>'required|string|max:150',
            'Unit'=>'required|string|max:50',
            'Min_Stock_Level'=>'required|int|max:10'
        ]);
        $stock->update($validated);
        return Redirect()->route('stock.index')->with('succes','stok berhasil diupdate');
    }
    public function destroy(Stock $stock){
        $stock->delete();
        return Redirect()->route('stock.index')->with('succes','stok berhasil dihapus');
    }
}
