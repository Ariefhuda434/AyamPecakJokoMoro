<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function index()
    {
        $countMenu = Menu::Count();
        $menuData = DB::table('menus')
        ->join('recipies','menus.Recipe_id','=','recipies.Recipe_id')
        ->select([
            'menus.Menu_id as Menu_id',
            'menus.Name as nama_menu',
            'menus.Category as kategori',
            'menus.Menu_Status as status_menu',
            'menus.Photo as foto_menu',
            'menus.Price as harga',
            'recipies.Name as nama_resep',
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
        $request->validate([
            'Category' => 'required',
            'Name' => 'required',
            'Price' => 'required|numeric',
            'Menu_Status' => 'required',
            'Recipe_id' => 'required|exists:recipe,Recipe_id',
        ]); 

        Menu::create($request->all());

        return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        $recipes = Recipe::all();
        return view('menu.edit', compact('menu', 'recipes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'Category' => 'required',
            'Name' => 'required',
            'Price' => 'required|numeric',
            'Menu_Status' => 'required',
            'Recipe_id' => 'required|exists:recipe,Recipe_id',
        ]);

        $menu = Menu::findOrFail($id);
        $menu->update($request->all());

        return redirect()->route('menu.index')->with('success', 'Menu berhasil diupdate!');
    }

    public function destroy($id)
    {
        Menu::destroy($id);
        return redirect()->route('menu.index')->with('success', 'Menu berhasil dihapus!');
    }
}
