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
        $anu = $request->validate([
            'name_employee' => 'required|string', 
            'password' => 'required',
        ]);

        $remember = $request->filled('remember');

        if (Auth::attempt($anu, $remember)) {
            $request->session()->regenerate();
            return redirect()->route('order.index')->with('succes','berhasil');
        }
        return back()->withErrors([
            'name_employee' => 'Email atau password salah.',
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