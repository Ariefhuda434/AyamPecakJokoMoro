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
        'Unit'              => 'required|string|max:50',
        'Update_Quantity'   => 'required|numeric|min:1', 
        'Price'             => 'required|numeric', 
    ]);

    $stock = Stock::findOrFail($validatedData['Stock_id']);

    $jumlah_sebelum_restock = $stock->Current_Quantity; 
    
    $jumlah_setelah = $jumlah_sebelum_restock + $validatedData['Update_Quantity'];

    $logData = [
        'Stock_id'              => $stock->Stock_id,
        'unit'                  => $validatedData['Unit'],
        'Stock_Before'        => $jumlah_sebelum_restock, 
        'Update_Quantity'    => $validatedData['Update_Quantity'],
        'Price'         => $validatedData['Price'],
        'created_at'       => now(),
    ];

    RestockLog::create($logData);

    $stock->update([
        'Current_Quantity' => $jumlah_setelah, 
        'Last_Restock_Date' => now(), 
    ]);
    $slug = Str::slug($stock->Name_Stock);
    return redirect()->route('restock.index', [
        'slug' => $slug,
        'stock_id' => $stock->Stock_id
        ])
    ->with('success', 'Restok **' . $stock->Name_Stock . '** berhasil ditambahkan! Stok saat ini: ' . $jumlah_setelah);
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RestockLog $restockLog)
    {
        DB::beginTransaction();
        try {
        $stock = Stock::findOrFail($restockLog->Stock_id);

        $newQuantity = $stock->Current_Quantity - $restockLog->Update_Quantity;

        if ($newQuantity < 0) {
            DB::rollBack();
            return back()->with('error', 'Tidak dapat menghapus log: Stok saat ini akan menjadi negatif. Mohon periksa kembali.');
        }

        $stock->update([
            'Current_Quantity' => $newQuantity,
            'Last_Restock_Date' => now(), 
        ]);

        $restockLog->delete();
        
        DB::commit();

        $slug = Str::slug($stock->Name_Stock);

        return redirect()->route('restock.index', ['slug' => $slug])
                         ->with('success', 'Log restok **' . $stock->Name_Stock . '** berhasil dihapus. Stok saat ini: ' . $newQuantity);

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Gagal menghapus log restok: ' . $e->getMessage());
    }

    }
}
