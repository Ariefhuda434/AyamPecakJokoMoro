<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login_view()
    {
        return view('auth.login'); 
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'name_employee' => 'required|string', 
            'password' => 'required',
        ]);

        $remember = $request->filled('remember');

        $loginField = 'name_employee'; 
        
        if (Auth::attempt([$loginField => $request->name_employee, 'password' => $request->password], $remember)) {
            
            $request->session()->regenerate();
            
            $karyawan = Auth::user();
        
            if ($karyawan->role === 'manager') {
                return redirect()->route('dashboard.view'); 
            } elseif ($karyawan->role === 'waiter') {
                return redirect()->route('order.index'); 
            } elseif ($karyawan->role === 'cashier') {
                return redirect()->route('transactions.index'); 
            }
            return redirect()->route('auth.login'); 
        }

        throw ValidationException::withMessages([
            'name_employee' => ['Nama pengguna atau password salah.'],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login'); 
    }
}