<?php

namespace App\Http\Controllers;

use PDO;
use App\Models\Table;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

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
        // $tables = Table::with('activeCustomer')->get();

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
        
        try {
            
            $query = "CALL SP_CustomerJoin(?, ?, ?)";
            $result = DB::select($query, [
            $validated['Name'],
            $validated['Phone_Number'],
            $validated['No_Table']
        ]);
        if (empty($result) || !isset($result[0]->Customer_id)) {
             throw new \Exception("Gagal mendapatkan ID pelanggan dari Stored Procedure.");
        }
        
        $newCustomerId = $result[0]->Customer_id;
        
        
        return redirect()->route('customer.index', [
            'No_Table' => $validated['No_Table'],
            'customers' => $newCustomerId
        ])->with('success', 'Customer berhasil duduk dan meja terisi! (ID Pelanggan: ' . $newCustomerId . ')');
        } catch (\PDOException $e) {
            $message = $e->getMessage();
            
            if (strpos($message, '45000') !== false) {
                 $cleanMessage = preg_replace('/SQLSTATE\[45000\]: <<unknown error>>: /', '', $message);
                 return redirect()->back()->withInput()->with('error', $cleanMessage);
            }
    
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan server database: ' . $message);
            
        }
    }

    public function out(Request $request, Table $table)
    {
       if ($table->status_table !== 'Terisi') {
        return redirect()->route('customer.index')->with('error', 'Meja ini sudah kosong atau tidak terisi.');
    }
    
    $noTable = $table->No_Table;

    $logAction = 'Keluar tanpa memesan'; 

      $query = "CALL SP_CustomerOut(?, ?)"; 
        
        DB::statement($query, [
            $noTable,
            $logAction
        ]);
        
        $table->refresh(); 

        return redirect()->route('customer.index')
                         ->with('success', 'Meja ' . $table->No_Table . ' berhasil dikosongkan. Pelanggan batal dan data diarsipkan.');
        }

}

