<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Exports\MonthlySalesExport;

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

        $penjualanHariIni = DB::table('view_penjualan_harian')
        ->where('Tanggal', $tanggalHariIni) 
        ->first();

        $pendapatanBulanan = DB::table('view_pendapatan_bulanan')
        ->limit(12) 
        ->get();

        $dataPenjualanBulanan = DB::table('view_pendapatan_bulanan')
        ->orderBy('Tahun_Bulan', 'ASC') 
        ->limit(12) 
        ->get();
        $labels = [];
        $pendapatanData = [];
        $penjualanData = [];

    foreach ($dataPenjualanBulanan as $data) {
 
        $bulanSingkat = Carbon::createFromFormat('Y-m', $data->Tahun_Bulan)->format('M');
        
        $labels[] = $bulanSingkat;
        $pendapatanData[] = $data->Total_Pendapatan_Bulan; 
        
        $penjualanData[] = $data->Total_Pendapatan_Bulan * 1.1; 
    }
        $tahunBulanSekarang = Carbon::now()->format('Y-m');

        $pendapatanBulanIni = DB::table('view_pendapatan_bulanan')
    ->where('Tahun_Bulan', $tahunBulanSekarang)
    ->first();
        return view('dashboard',[
            'menuData' => $menuData,
            'mejaTerpakai' => $mejaTerpakai,
            'mejaTotal' =>$mejaTotal,
            'penjualanHariIni' =>$penjualanHariIni,
            'tanggalHariIni' =>$tanggalHariIni,
            'pendapatanBulanIni' => $pendapatanBulanIni,
            'pendapatanBulanan' => $pendapatanBulanan,
            'tahunBulanSekarang' => $tahunBulanSekarang,
            'chartLabels' => $labels,
            'chartPendapatan' => $pendapatanData,
            'chartPenjualan' => $penjualanData,
        ]);
    }
    public function exportReport(Request $request)
    {
        $year = $request->input('year', now()->year);
        
        $fileName = 'Laporan_Bulanan_Penjualan_Pendapatan_' . $year . '.xlsx';
        
        return Excel::download(new MonthlySalesExport($year), $fileName);
    }
   
}
