<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\select;

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
    // ... (Pastikan ada: use Illuminate\Support\Facades\DB; )

    public function store(Request $request)
    {
        try {
            $currentEmployeeId = \Illuminate\Support\Facades\Auth::user()->Employee_id;

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
   // ... (Pastikan ada: use Illuminate\Support\Facades\DB; )

    public function update(Request $request, Employee $employee)
    {
        try {
            DB::beginTransaction(); 

            $validated = $request->validate([
                'name_employee' => 'required|string|max:150',
                'number_phone' => 'required|string|max:20',
                'role_id' => 'required|exists:roles,role_id',
                'password' => 'nullable|string|min:6', 
            ]);

            if (empty($validated['password'])) {
                unset($validated['password']);
            } else {
                $validated['password'] = Hash::make($request->input('password'));
            }

            $employee->update($validated);
            
            DB::commit();

            return redirect()->route('employee.index')->with('success', 'Data karyawan berhasil diubah!');
        } catch (\Exception $e) {
            DB::rollBack(); // Membatalkan Transaksi
            return redirect()->back()->withInput()->with('error', 'Gagal mengubah data karyawan. Transaksi dibatalkan.');
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employee.index')->with('success', 'Data karyawan berhasil dihapus!');
    }
}
