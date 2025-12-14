<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function index(){
    $tables = Table::orderBy('No_Table', 'asc')->get();
       return view('table.meja',compact('tables'));
    }
    public function table_create(Request $request){
        Table::create();  
        return redirect()->route('table.index')->with('success', 'Jumlah meja berhasil ditambahkan!');
    }

    public function destroy(Table $table)
    {
        if ($table->status_table === 'Terisi') {
            return redirect()->route('table.index')->with('error', 'Meja TIDAK dapat dihapus karena sedang terisi. Harap selesaikan transaksi terlebih dahulu.');
        }

        $table->delete();

        return redirect()->route('table.index')->with('success', 'Konfigurasi meja berhasil dihapus.');
    }
}
