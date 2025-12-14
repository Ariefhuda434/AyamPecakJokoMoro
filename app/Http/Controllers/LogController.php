<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class LogController extends Controller
{
    public function indexLog(Request $request)
    {
        $query = DB::table('audit_logs')
            ->join('employees', 'audit_logs.Employee_id', '=', 'employees.Employee_id')
            ->select('audit_logs.*', 'employees.Name_Employee as employee_name')
            ->orderBy('audit_logs.Change_time', 'desc');

        $actionType = $request->get('action_type');
        if ($actionType && $actionType !== 'all') {
            $query->where('audit_logs.Action_Typn', $actionType);
        }

        $tableName = $request->get('table_name');
        if ($tableName && $tableName !== 'all') {
            $query->where('audit_logs.Table_Name', $tableName);
        }
        
        $logData = $query->paginate(25)->withQueryString();
        
        $availableTables = DB::table('audit_logs')->distinct()->pluck('Table_Name');

        $latestActivities = $this->getLatestActivityLogs(5); 

        return view('dashboard.log', [
            'logData' => $logData,
            'availableTables' => $availableTables,
            'latestActivities' => $latestActivities, 
        ]);
    }
    
  
    public function getLatestActivityLogs($limit = 5)
    {
        $latestLogs = DB::table('audit_logs')
            ->join('employees', 'audit_logs.Employee_id', '=', 'employees.Employee_id')
            ->select(
                'audit_logs.Change_time',
                'audit_logs.Table_Name',
                'audit_logs.Record_ID',
                'audit_logs.Action_Typn', 
                'audit_logs.Column_Name',
                'audit_logs.Old_Value',
                'audit_logs.New_Value',
                'audit_logs.Employee_id',
                'employees.Name_Employee as employee_name'
            )
            ->orderBy('audit_logs.Change_time', 'desc')
            ->limit($limit)
            ->get();
            
        $processedLogs = $latestLogs->map(function ($log) {
            $description = $this->createLogDescription($log);

            $employeeName = $log->employee_name ?? 'N/A';

            return [
                'description' => $description['text'],
                'category' => $description['category'],
                'time_ago' => Carbon::parse($log->Change_time)->diffForHumans(),
                'employee_name' => $employeeName,
                'employee_id' => $log->Employee_id,
                'action_type' => $log->Action_Typn,
                'table_name' => $log->Table_Name,
            ];
        });

        return $processedLogs;
    }

  
    private function createLogDescription($log)
    {
        $action = $log->Action_Typn;
        $table = strtoupper($log->Table_Name);
        $column = $log->Column_Name;
        $desc = '';
        $category = '';

        if ($table == 'STOCKS') {
            $category = 'Stok Bahan Baku';
            if ($action == 'UPDATE' && $column == 'Current_Stock') {
                $desc = "Pembaruan Stok ({$log->Record_ID}).";
            } elseif ($action == 'CREATE') {
                $desc = "Bahan Stok Baru **" . ($log->New_Value ?? 'N/A') . "** ditambahkan."; 
            }
        } elseif ($table == 'MENUS') {
            $category = 'Manajemen Menu';
            if ($action == 'CREATE') {
                $desc = "Menu Baru: **" . ($log->New_Value ?? 'N/A') . "** Ditambahkan.";
            } elseif ($action == 'UPDATE' && $column == 'Price') {
                $desc = "Harga Menu ({$log->Record_ID}) diperbarui dari Rp {$log->Old_Value} menjadi Rp {$log->New_Value}.";
            }
        } elseif ($table == 'EMPLOYEES') {
            $category = 'Manajemen Karyawan';
            if ($action == 'UPDATE' && $column == 'Role') {
                $desc = "Role Karyawan (ID: {$log->Record_ID}) diubah dari **{$log->Old_Value}** menjadi **{$log->New_Value}**.";
            } else {
                $desc = "Update Data Karyawan (ID: {$log->Record_ID}, Kolom: **{$column}**).";
            }
        } elseif ($table == 'ORDERS') {
            $category = 'Transaksi & Penjualan';
            if ($action == 'CREATE') {
                $desc = "Order Baru (ID: {$log->Record_ID}) telah dibuat.";
            } elseif ($action == 'UPDATE' && $column == 'Order_Status') {
                $desc = "Status Order ({$log->Record_ID}) diubah dari **{$log->Old_Value}** menjadi **{$log->New_Value}**.";
            } else {
                $desc = "Perubahan data Order ({$log->Record_ID}, Kolom: {$column}).";
            }
        } elseif ($table == 'TRANSACTIONS') {
            $category = 'Transaksi & Penjualan';
            if ($action == 'UPDATE' && $column == 'Method_Payment') {
                $desc = "Pembayaran Transaksi ({$log->Record_ID}) diselesaikan dengan metode **{$log->New_Value}**.";
            } else {
                $desc = "Perubahan data Transaksi ({$log->Record_ID}, Kolom: {$column}).";
            }
        } elseif ($table == 'TABLES') {
            $category = 'Manajemen Meja';
            if ($action == 'UPDATE' && $column == 'Status') {
                $desc = "Status Meja **{$log->Record_ID}** diubah dari **{$log->Old_Value}** menjadi **{$log->New_Value}**.";
            } else {
                $desc = "Update data Meja **{$log->Record_ID}** (Kolom: {$column}).";
            }
        } elseif ($table == 'CUSTOMERS') {
            $category = 'Data Pelanggan';
            if ($action == 'DELETE') {
                 $desc = "Data Pelanggan (ID: {$log->Record_ID}) dihapus.";
            } else {
                 $desc = "Update data Pelanggan (ID: {$log->Record_ID}, Kolom: {$column}).";
            }
        } else {
            $category = 'Aktivitas Lain';
            $desc = "Aksi {$action} pada tabel {$table} (Kolom: {$column}).";
        }

        return ['text' => $desc, 'category' => $category]; 
    }
}