<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ManagerController extends Controller
{
    public function index()
    {
        $menuData = DB::table('view_menu_recipes')
            ->get();
        
            $mejaTerpakai = DB::table('tables')
        ->where('status_table', 'Terisi')
        ->count();

        $mejaTotal = DB::table('tables')
        ->select('No_Table as jumlah_meja') 
        ->count();

        $tanggalHariIni = Carbon::now()->toDateString();

        $penjualanHariIni = DB::table('transactions')
        ->where('Date', $tanggalHariIni) 
        ->first();

        

        return view('dashboard',[
            'menuData' => $menuData,
            'mejaTerpakai' => $mejaTerpakai,
            'mejaTotal' =>$mejaTotal,
            'penjualanHariIni' =>$penjualanHariIni,
            'tanggalHariIni' =>$tanggalHariIni
        ]);
    }
   
}
