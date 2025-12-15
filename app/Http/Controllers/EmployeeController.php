<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use function Laravel\Prompts\select;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countEmployee = Employee::count();

        $employeeData = DB::table('view_employees')
            ->orderBy('Tanggal_bergabung', 'desc')
            ->get();

        return view('karyawan', [
            'employeeData' => $employeeData,
            'countEmployee' => $countEmployee
        ]);
    }


    public function store(Request $request)
    {
        
        try {
            $currentEmployeeId = Auth::user()->Employee_id;
            DB::statement("SET @current_employee_id = ?", [$currentEmployeeId]);

            $validated = $request->validate([
                'name_employee' => 'required|string|max:150',
                'number_phone' => 'required|string|max:20',
                'role_id' => 'required|exists:roles,role_id',
                'password' => 'required|string|min:6',
            ]);
            
            $validated['password'] = Hash::make($request->input('password'));
            $validated['date_join'] = Carbon::now();
            
            Employee::create($validated);

            DB::commit(); 

            return redirect()->route('employee.index')->with('success', 'Data karyawan berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data karyawan. Transaksi dibatalkan.');
        }
    }


    public function update(Request $request, Employee $employee)
    {
        try {
            DB::beginTransaction(); 
            $currentEmployeeId = Auth::user()->Employee_id;

            DB::statement("SET @current_employee_id = ?", [$currentEmployeeId]);
            $validated = $request->validate([
                'name_employee' => 'required|string|max:150',
                'number_phone' => 'required|string|max:20',
                'role_id' => 'required|exists:roles,role_id',
                'password' => 'nullable|string|min:6', 
            ]);

            // dd($request->input());
            if (empty($validated['password'])) {
                unset($validated['password']);
            } else {
                $validated['password'] = Hash::make($request->input('password'));
            }
            $employee->update($validated);

            DB::commit();

            return redirect()->route('employee.index')->with('success', 'Data karyawan berhasil diubah!');
        } catch (\Exception $e) {
            DB::rollBack(); 
            Log::error("UPDATE FAILED: " . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    public function destroy(Employee $employee)
    {
        $currentEmployeeId = Auth::user()->Employee_id;
        DB::statement("SET @current_employee_id = ?", [$currentEmployeeId]);

        $employee->delete();
        return redirect()->route('employee.index')->with('success', 'Data karyawan berhasil dihapus!');
    }
}
