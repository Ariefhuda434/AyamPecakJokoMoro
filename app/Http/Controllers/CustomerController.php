<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\Customer;
use Illuminate\Http\Request;
use PDO;

class CustomerController extends Controller
{
    /**
     * Menampilkan daftar semua meja dengan opsi filter.
     */
    public function index(Request $request)
    {
        $statusFilter = $request->get('status_table');

        $querytable = Table::with('customer');

        if ($statusFilter) {
            $querytable->where('status_table', $statusFilter);
        }
      
        $tables = $querytable->get();
        

        $totalTables = Table::count();
        $availableTables = Table::where('status_table', 'Kosong')->count();
        $occupiedTables = Table::where('status_table', 'Terisi')->count(); 
        
        return view('order', [
            'tables' => $tables,
            'totalTables' => $totalTables,
            'availableTables' => $availableTables,
            'occupiedTables' => $occupiedTables,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Name' => 'required|string|max:20',
            'Phone_Number' => 'required|string|max:14',
            'No_Table' => 'required|numeric|min:1',
        ]);
        
        $customers = Customer::create($validated);

        $table = Table::where('No_Table', $validated['No_Table'])->firstOrFail();
        
        $table->update([
             'status_table' => 'Terisi', 
        ]);

        return redirect()->route('customer.index',[
        'customers' => $customers
        ])->with('success', 'Customer berhasil duduk dan meja terisi!');
    } 

    public function out(Request $request, Table $table)
    {
        if ($table->status_table !== 'Terisi') {
            return redirect()->route('customer.index')->with('error', 'Meja ini sudah kosong atau tidak terisi.');
        }

        $table->update([
             'status_table' => 'Kosong', 
             'customer_id' => null, 
        ]);
        
        return redirect()->route('customer.index')->with('success', 'Meja ' . $table->No_Table . ' berhasil dikosongkan!');
    }

}