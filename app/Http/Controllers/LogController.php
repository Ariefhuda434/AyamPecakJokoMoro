<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogController extends Controller
{
     public function indexLog()
    {
        $stockLogs = DB::table('audit_logs')
        ->where('Table_Name', 'stocks') 
        ->join('Employees', 'audit_logs.Employee_id', '=', 'Employees.Employee_id') 
        ->select('audit_logs.*', 'Employees.Name_Employee as employee_name')
        ->orderBy('Change_time', 'desc')
        ->get();

        return view('dashboard.log',['logData' => $stockLogs]);
    }
}
