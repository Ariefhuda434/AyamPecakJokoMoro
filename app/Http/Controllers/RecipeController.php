<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\RecipePivot; // Pastikan model ini ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class RecipeController extends Controller
{
   public function index(Request $request, string $slug)
{
    $menu = Menu::where('slug', $slug)->firstOrFail();

    $resepid = $menu->Recipe_id;

    $resepData = DB::table('view_resep_stok')
        ->where('Recipe_id', $resepid)
        ->get();

    $stockData = DB::table('stocks')
        ->select([
            'Stock_id',
            'Name_Stock as nama_stock_resep',
            'Unit as satuan_resep'
        ])
        ->get();

    return view('recipies', [
        'menu' => $menu,
        'resepData' => $resepData,
        'stockData' => $stockData
    ]);
}


    public function store(Request $request)
    {
        $validated = $request->validate([
            'Stock_id' => 'required|numeric',
            'Recipe_id' => 'required|numeric',
            'Quantity' => 'required|numeric|min:0',
        ]);
        
        RecipePivot::updateOrCreate(
            [
                'Recipe_id' => $validated['Recipe_id'],
                'Stock_id' => $validated['Stock_id'],
            ],
            [
                'Quantity' => $validated['Quantity']
            ]
        );        
        $menu = Menu::where('Recipe_id', $validated['Recipe_id'])->first();

        if ($menu) {
            return redirect()->route('recipies.index', ['slug' => $menu->slug])
                             ->with('success','Bahan resep berhasil ditambahkan/diperbarui.');
        }

        return back()->with('success','Bahan resep berhasil ditambahkan/diperbarui.');
    }

}