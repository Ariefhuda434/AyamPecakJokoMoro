<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class StockController extends Controller
{
  public function index()
{
    $stockData = DB::table('view_stock_restock')
        ->orderBy('tanggal_restock_terakhir', 'desc') 
        ->get();

    return view('stock', compact('stockData'));
}
}
