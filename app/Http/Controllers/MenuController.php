<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Recipe;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
 public function index(Request $request)
    {
        $countMenu = Menu::count();

        $menuData = DB::table('view_menu_recipes')
            ->get();
        // dd($menuData);
        return view('dashboardmenu', [
            'menuData' => $menuData,
            'countMenu' => $countMenu
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
        'photo' => 'required|image|mimes:jp eg,png,jpg|max:2048', 
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
            // 'Menu_Status' => $validated['Menu_Status'] ?? 'Tidak Tersedia', 
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
    // Cek apakah menu terkait memiliki Recipe_id
    if (!$menu->Recipe_id) {
        // Jika tidak ada Recipe_id, kita tidak bisa update resep.
        return redirect()->back()->with('error', 'Menu ini tidak terhubung dengan Resep, tidak dapat diupdate.');
    }

    // 1. Validasi Input
    $validated = $request->validate([
        'Category' => 'required|string|max:255',
        'Name' => 'required|string|max:255',
        'Price' => 'required|numeric|min:0',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Foto sekarang nullable
        'Name_Resep' => 'required|string|max:255', // Validasi untuk update resep
        'Keterangan' => 'nullable|string', // Validasi untuk update keterangan resep
        'Menu_Status' => 'required|string', // Pastikan input ini ada di form
    ]);

    DB::beginTransaction();
    try {
        $photoPath = $menu->photo; // Ambil path foto lama sebagai default
        
        // 2. Tangani Upload Foto
        if ($request->hasFile('photo')) {
            if ($menu->photo && Storage::disk('public')->exists($menu->photo)) {
                Storage::disk('public')->delete($menu->photo);
            }
            
            // Simpan foto baru
            $path = $request->file('photo')->store('menu', 'public');
            $photoPath = $path;
        }

        // 3. Update Data Resep (Tabel Recipe)
        $recipe = Recipe::findOrFail($menu->Recipe_id);
        $recipe->update([
            'Name_Resep' => $validated['Name_Resep'],
            'Keterangan' => $validated['Keterangan'] ?? null,
        ]);
        
        $menu->update([
            'Category' => $validated['Category'],
            'Name' => $validated['Name'],
            'Price' => $validated['Price'],
            'status_menu' => $validated['Menu_Status'], 
            'photo' => $photoPath,
        ]);
        
        DB::commit();
        return redirect()->route('menu.index')->with('success', 'Menu dan Resep berhasil diupdate!');
        
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error("Gagal mengupdate Menu: " . $e->getMessage());
        return redirect()->back()->withInput()->with('error', 'Gagal mengupdate menu. Pesan teknis: ' . $e->getMessage());
    }
}
    
    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('menu.index')->with('success', 'Menu berhasil dihapus!');
    }
}
