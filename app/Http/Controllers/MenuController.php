<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Recipe;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $countMenu = Menu::Count();
        $menuId = $request->query('menu_id');
        $menuData = DB::table('menus')
        ->join('recipies','menus.Recipe_id','=','recipies.Recipe_id')
        ->select([
            'menus.Menu_id as Menu_id',
            'menus.Name as nama_menu',
            'menus.Category as kategori',
            'menus.slug as slug',
            'menus.Menu_Status as status_menu',
            'menus.photo as foto_menu',
            'menus.Price as harga',
            'recipies.Name_Resep as nama_resep',
            'recipies.Keterangan as keterangan_resep',
        ])
        ->orderBy('menus.created_at','desc')
        ->get();
        return view('dashboardmenu', [
            'menuData' =>$menuData,
            'countMenu' =>$countMenu
        ]);
    }

    public function create()
    {
        $recipes = Recipe::all(); 
        return view('menu.create', compact('recipes'));
    }

public function store(Request $request)
{
    $validated = $request->validate([
        'Category' => 'required',
        'Name' => 'required|string|max:255',
        'Price' => 'required|numeric|min:0',
        'Menu_Status' => 'nullable|string', 
        'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048', 
        'Name_Resep' =>'required|string|max:255',
        'Keterangan' =>'nullable|string', 
    ]);
    
    DB::beginTransaction(); 
    try {
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('public/menu_photos');
            $photoPath = str_replace('public/', '', $path); 
        }

        
        $path = $request->file('photo')->store('menu', 'public');
        $foto = $validated['photo'] = $path;

        $recipeData = Recipe::create([
            'Name_Resep' => $validated['Name_Resep'],
            'Keterangan' => $validated['Keterangan'] ?? null, 
        ]);
        $newRecipeId = $recipeData->Recipe_id; 
        
        Menu::create([
            'Category' => $validated['Category'],
            'Name' => $validated['Name'],
            'Price' => $validated['Price'],
            'Menu_Status' => $validated['Menu_Status'] ?? 'Tidak Tersedia', 
            'photo' => $foto, 
            'Recipe_id' => $newRecipeId, 
        ]);
        DB::commit(); 
        return redirect()->route('menu.index')->with('success', 'Menu dan Resep berhasil dibuat!');

    } catch (\Exception $e) {
        DB::rollBack(); 
        
        Log::error("Gagal menyimpan Menu atau Resep: " . $e->getMessage()); 
        
        return redirect()->back()
            ->withInput()
            ->with('error', 'Gagal menyimpan data menu. Mohon periksa log atau hubungi administrator. Pesan teknis: ' . $e->getMessage());
    
}
}

    public function update(Request $request, Menu $menu)
    {
        $validated=$request->validate([
            'Category' => 'required',
            'Name' => 'required',
            'Price' => 'required|numeric',
            'Menu_Status' => 'required',
            'Recipe_id' => 'required|exists:recipe,Recipe_id',
        ]);

        $menu->update($validated);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil diupdate!');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('menu.index')->with('success', 'Menu berhasil dihapus!');
    }
}
