<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        if (Auth::attempt($request->only('name_employee', 'password'), $remember)) {
            $request->session()->regenerate();
            return redirect($this->_getRedirectRoute());
            // return redirect('dashboard');
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