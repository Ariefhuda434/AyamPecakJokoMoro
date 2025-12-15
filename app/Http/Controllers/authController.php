<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    private function _getRedirectRoute()
    {
        if (!Auth::check()) {
            return route('login.view');
        }
        $employee = Auth::user();
        
        if (!$employee || !isset($employee->role) || !$employee->role) { 
            Auth::logout();
            return route('login.view');
        }
        $roleSlug = $employee->role->slug; 
        if ($roleSlug === 'manager') {
            return route('dashboard.view'); 
        } elseif ($roleSlug === 'waiter') {
            return route('customer.index'); 
        } elseif ($roleSlug === 'cashier') {
            return route('cashier.view'); 
        }
        Auth::logout();
        return route('login.view'); 
    }
    


    public function login_view()
    {
        if (Auth::check()) {
            return redirect($this->_getRedirectRoute());
        }
        return view('auth.login'); 
    }

     public function login(Request $request)
{
    $request->validate([
        'name_employee' => 'required|string', 
        'password' => 'required',
    ]);
    
    $remember = $request->filled('remember');
    $name_employee = $request->input('name_employee');
    $password = $request->input('password');
    $rememberToken = NULL;

    $results = DB::select(
        "CALL SP_EmployeeLoginAndTokenUpdate(?, ?)", 
        [
            $name_employee, 
            NULL 
        ]
    );

    $employeeData = collect($results)->first();

    if ($employeeData) {
        $employee = (new Employee())->forceFill((array) $employeeData);
    } else {
        $employee = null;
    }
    if ($employee && Hash::check($password, $employee->password)) {   
        Auth::login($employee, $remember); 
        $request->session()->regenerate();
        if ($remember) {
            $rememberToken = Str::random(60);
            DB::statement(
                "CALL SP_EmployeeLoginAndTokenUpdate(?, ?)", 
                [
                    $name_employee, 
                    $rememberToken 
                ]
            );
            $employee->remember_token = $rememberToken; 
        }
        return redirect($this->_getRedirectRoute());
    }
    return back()->withErrors([
        'name_employee' => 'Nama Karyawan atau password salah.',
    ])->onlyInput('name_employee');
}


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.view'); 
    }
}