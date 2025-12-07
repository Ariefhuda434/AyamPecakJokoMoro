<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Table;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status_filter = $request->query('status_table');

        $query = Table::query();
        
        $query->with('activeCustomer'); 

        if ($status_filter) {
            $query->where('status_table', $status_filter);
        }
        
        $tables = $query->get();

        $totalTables = Table::count(); 
        $availableTables = Table::where('status_table', 'Kosong')->count();
        $occupiedTables = Table::where('status_table', 'Terisi')->count();
        

        return view('order', compact(
            'tables', 
            'totalTables', 
            'availableTables', 
            'occupiedTables'
        ));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
