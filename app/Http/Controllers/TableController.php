<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function table_create(Request $request){
        $validated = $request->validate([
            'number_table' => 'required|int|max:6',
        ]);
        Table::create($validated);
        return redirect()->route('order.index')->with('success', 'Jumlah meja berhasil ditambahkan!');
    }
}
