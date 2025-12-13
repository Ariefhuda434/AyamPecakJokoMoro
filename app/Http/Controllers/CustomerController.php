<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\Customer;
use Illuminate\Http\Request;
use PDO;

class CustomerController extends Controller
{
    
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
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'Name' => 'required|string|max:20',
                'Phone_Number' => 'required|string|max:14',
                'No_Table' => 'required|numeric|min:1',
            ]);
            
            $customers = Customer::create([
                'Name' => $validated['Name'],
                'Phone_Number' => $validated['Phone_Number'],
            ]);

            $table = Table::where('No_Table', $validated['No_Table'])->firstOrFail();
            
            $table->update([
                'status_table' => 'Terisi',
                'customer_id' => $customers->id, 
            ]);

            DB::commit();

            return redirect()->route('customer.index',[
                'No_Table' => $table->No_Table,
                'customers' => $customers->id
            ])->with('success', 'Customer berhasil duduk dan meja terisi!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data. Transaksi dibatalkan.');
        }
    }

    public function out(Request $request, Table $table)
    {
        if ($table->status_table !== 'Terisi') {
            return redirect()->route('customer.index')->with('error', 'Meja ini sudah kosong atau tidak terisi.');
        }
        
        try {
            DB::beginTransaction();
            
            $table->update([
                'status_table' => 'Kosong', 
                'customer_id' => null, 
            ]);

            DB::commit();
        
            return redirect()->route('customer.index')->with('success', 'Meja ' . $table->No_Table . ' berhasil dikosongkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('customer.index')->with('error', 'Terjadi kesalahan saat mengosongkan meja. Transaksi dibatalkan.');
        }
    }

}

