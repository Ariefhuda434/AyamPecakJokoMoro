<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Stock;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\RecipePivot; // Pastikan model ini ada


class RecipeController extends Controller
{
   public function index(Request $request, string $slug)
{
    $menu = Menu::where('slug', $slug)->firstOrFail();
// dd($menu);
    $resepid = $menu->Recipe_id;

    $resepData = DB::table('view_resep_stok')
        ->where('id_resep', $resepid)
        ->first();
    //jangan ilang bil
    $Data = DB::table('recipe_pivot')
        ->join('stocks','stocks.Stock_id','=','recipe_pivot.Stock_id')
        ->join('recipies','recipies.Recipe_id','=','recipe_pivot.Recipe_id')
        ->join('menus','menus.Recipe_id','=','recipies.Recipe_id')
        ->where('menus.Recipe_id',$resepid)
        ->select([
            'stocks.Stock_id',
            'stocks.Name_Stock as nama_stock_resep',
            'stocks.Unit as Satuan_resep',
            'recipe_pivot.Quantity as jumlah_stock_resep',
        ])->get();
        
        // dd($resepData);
    $stockData = DB::table('stocks')
        ->select([
            'Stock_id',
            'Name_Stock as nama_stock_resep',
            'Unit as satuan_resep'
        ])
        ->get();
        // dd($stockData);
    return view('recipies', [
        'menu' => $menu,
        'resepData' => $resepData,
        'stockData' => $stockData,
        'Data' => $Data
    ]);
}

     public function store(Request $request)
    {
        $validated = $request->validate([
            'Stock_id' => 'required|numeric',
            'Recipe_id' => 'required|numeric',
            'Quantity' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            RecipePivot::updateOrCreate(
                [
                    'Recipe_id' => $validated['Recipe_id'],
                    'Stock_id' => $validated['Stock_id'],
                ],
                [
                    'Quantity' => $validated['Quantity']
                ]
            );

            DB::commit();

            $menu = Menu::where('Recipe_id', $validated['Recipe_id'])->first();

            if ($menu) {
                return redirect()->route('recipies.index', ['slug' => $menu->slug])
                                 ->with('success', 'Bahan resep berhasil ditambahkan/diperbarui.');
            }

            return back()->with('success', 'Bahan resep berhasil ditambahkan/diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Gagal menambahkan/memperbarui bahan resep: " . $e->getMessage());

            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan bahan resep: ' . $e->getMessage());
        }
    }

    public function destroy(string $stock,string $recipe){
        // $stock->delete();
    $recipe1 = Recipe::findOrFail($recipe);
    $recipe1->stocksMagic()->detach($stock); 
    $menu = Menu::where('Recipe_id', $recipe)->first();
    if ($menu) {
        return redirect()->route('recipies.index', ['slug' => $menu->slug])
                         ->with('success', 'Bahan baku berhasil dihapus dari resep.');
    }
    return redirect()->back()->with('success', 'Bahan baku berhasil dihapus dari pivot.');
    }

}