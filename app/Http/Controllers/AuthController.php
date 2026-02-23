<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            Log::info("User berhasil login: " . $request->email);
            return redirect()->intended('dashboard')->with('success', 'Selamat datang kembali!');
        }

        Log::warning("Percobaan login gagal pada email: " . $request->email);
        return back()->with('error', 'Email atau password salah!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function showRegistrationForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'kode_admin' => 'required', // Input kode khusus
        ]);

        $secretCode = "TRIDJAYA2026"; 
        if ($request->kode_admin !== $secretCode) {
            return back()->with('error', 'Kode Admin tidak valid! Anda tidak memiliki akses.');
        }

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'photo' => 'default.png', 
            ]);

            Log::info("User baru terdaftar: " . $request->email);
            return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');

        } catch (\Exception $e) {
            Log::error("Gagal Register: " . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan sistem.');
        }
    }
}
