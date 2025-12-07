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
        $countEmployee = Employee::Count();
        $employeeData = DB::table('employees')
        ->join('roles','employees.role_id', '=', 'roles.role_id')
        ->select([
            'employees.Employee_id as Employee_id',
            'employees.name_employee as name_employee',
            'employees.number_phone as number_phone',
            'employees.created_at as date_join',
            'roles.role_name as role_name',
        ])
        ->orderBy('employees.created_at','desc')
        ->get();
        
        return view('karyawan',[
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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_employee' => 'required|string|max:150',
            'number_phone' => 'required|string|max:20',
            'role_id' => 'required|exists:roles,role_id',
            'password' => 'required|string|min:6',
        ]);
        $validated['password'] = Hash::make($request->input('password'));
        $validated['date_join'] = Carbon::now();
        Employee::create($validated);
        return redirect()->route('employee.index')->with('success', 'Data karyawan berhasil ditambahkan!');
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
    public function update(Request $request, Employee $employee)
{
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

    return redirect()->route('employee.index')->with('success', 'Data karyawan berhasil diubah!');
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
