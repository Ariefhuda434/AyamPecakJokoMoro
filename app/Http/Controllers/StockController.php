<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class StockController extends Controller
{
    public function index(){
$latestLog = DB::table('restock_log')
    ->select('Stock_Id', 'Price', 'created_at')
    ->orderByDesc('created_at')
    ->limit(1); 

$latestDate = DB::table('restock_log')
    ->select('Stock_Id', DB::raw('MAX(created_at) as max_created_at'))
    ->groupBy('Stock_Id');

$restockCount = DB::table('restock_log')
    ->select('Stock_Id', DB::raw('COUNT(Stock_Id) as total_restock_count'))
    ->groupBy('Stock_Id');


$stockData = DB::table('stocks')
    ->leftJoinSub($restockCount, 'total', function ($join) {
        $join->on('stocks.Stock_id', '=', 'total.Stock_Id');
    })
    ->leftJoinSub($latestDate, 'latest', function ($join) {
        $join->on('stocks.Stock_id', '=', 'latest.Stock_Id');
    })
    ->leftJoin('restock_log', function ($join) {
        $join->on('stocks.Stock_id', '=', 'restock_log.Stock_Id')
             ->on('latest.max_created_at', '=', 'restock_log.created_at'); 
    })
    ->select([
        'stocks.Stock_id as Stock_id',
        'stocks.Name_Stock as nama_stock',
        'stocks.Unit as unit',
        'stocks.Current_Stock as jumlah_terkini',
        'stocks.MIN_Stock_Level as jumlah_minimum',
        'restock_log.Price as harga_restock_terakhir',
        'latest.max_created_at as tanggal_restock_terakhir',
        
        'total.total_restock_count',
    ])
    ->orderBy('stocks.created_at','desc')
    ->get();

return view('stock', compact('stockData'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'Name_Stock'=>'required|string|max:150',
            'Unit'=>'required|string|max:50',
            'Min_Stock_Level'=>'required|int|max:10'
        ]);
        Stock::create($validated);
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
