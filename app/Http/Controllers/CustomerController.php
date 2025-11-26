<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Table;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request,Table $table)
    {
        $validated = $request->validate([
            'Name' => 'required|string|max:20',
            'Phone_Number' => 'required|string|max:14',
        ]);
        $validated['No_Table'] =  $table->No_Table;
        Customer::create($validated);
        $table->status_table = 'belum memesan';
        $table->save();
        return redirect()->route('order.index')->with('success', 'Data customer berhasil ditambahkan!');
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
