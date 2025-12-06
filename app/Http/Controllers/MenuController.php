<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Recipe;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('recipe')->get(); 
        return view('menu.index', compact('menus'));
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
