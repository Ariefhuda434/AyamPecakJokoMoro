<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MonthlySalesExport implements FromCollection, WithHeadings
{
    protected $year;

    public function __construct(int $year = null)
    {

        $this->year = $year ?? now()->year;
    }

    public function collection()
    {
        return DB::table('transactions')
                 ->select(
                     DB::raw('MONTH(Date) as Bulan'),
                     DB::raw('COUNT(Transaction_id) as Total_Penjualan'),
                     DB::raw('SUM(Total_Price) as Total_Pendapatan')
                 )
                 ->whereYear('Date', $this->year)
                 ->groupBy(DB::raw('MONTH(Date)'))
                 ->orderBy('Bulan')
                 ->get();
    }

    public function headings(): array
    {
        return [
            'Bulan',
            'Total Penjualan (Unit/Transaksi)',
            'Total Pendapatan (Rupiah)',
        ];
    }
}