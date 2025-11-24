<?php

namespace App\Http\Controllers;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login_view(){
        return view('auth/login');
    }
    public function login(Request $request){
        $request->validate([
            'name_employee' => 'required|email',
            'password' => 'required',
        ]);
        $remember = $request->filled('remember');
        if (Auth::attempt($request->only('email', 'password'), $remember)) {
            $request->session()->regenerate();
            return redirect('dashboard.view');
        }
        return back()->withErrors([
            'errors' => 'Nama atau password salah.',
        ]);

    }
     public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            // Jika pengguna belum login, redirect mereka ke halaman login.
            // Anda bisa mengganti 'login' dengan nama rute halaman login Anda.
            return redirect()->route('login')->with('error', 'Anda harus login untuk mengakses halaman ini.');
        }

        // Jika pengguna sudah login, lanjutkan request ke controller/rute tujuan.
        return $next($request);
    }
}
