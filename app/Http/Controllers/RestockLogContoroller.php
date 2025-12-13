<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\RestockLog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RestockLogContoroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(String $slug, Request $request)
{
    $stockId = $request->query('stock_id');

    if (!$stockId) {
        return back()->with('error', 'Stock ID tidak ditemukan.');
    }

    $stock = Stock::findOrFail($stockId);

    $restockData = DB::table('view_restock_log')
        ->where('Stock_id', $stockId)
        ->orderBy('tanggal_restock', 'desc')
        ->get();

    return view('restock', [
        'stock' => $stock,
        'restockData' => $restockData
    ]);
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
 public function store(Request $request){
    $validatedData = $request->validate([
        'Stock_id'          => 'required|exists:stocks,Stock_id', 
        'unit'              => 'required|string|max:50',
        'Update_Quantity'   => 'required|numeric|min:1', 
        'Price'             => 'required|numeric', 
    ]);

    $query = "CALL SP_ProcessRestock(?, ?, ?, ?)";
        DB::statement($query, [
            $validatedData['Stock_id'],
            $validatedData['unit'],
            $validatedData['Update_Quantity'],
            $validatedData['Price']
        ]);
    $stock = Stock::findOrFail($validatedData['Stock_id']); 
    $slug = Str::slug($stock->Name_Stock);
       
    return redirect()->route('restock.index', [
        'slug' => $slug,
        'stock_id' => $stock->Stock_id
        ])
    ->with('success', 'Restok berhasil ditambahkan! Stok saat ini: ' . $stock->Current_Stock);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RestockLog $restockLog)
    {
        try {
        $query = "CALL SP_DeleteRestockLog(?)";
        DB::statement($query, [$restockLog->Restock_id]);
        $stock = Stock::findOrFail($restockLog->Stock_id); 
        $slug = Str::slug($stock->Name_Stock);

        return redirect()->route('restock.index', ['slug' => $slug])
             ->with('success', 'Log restok **' . $stock->Name_Stock . ' berhasil dihapus. Stok saat ini: ' . $stock->Current_Stock);
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Gagal menghapus log restok: ' . $e->getMessage());
    }

    }
}
