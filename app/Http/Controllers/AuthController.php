<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Dokter;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin() { return view('auth.login'); }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Cari di tabel dokter
        $dokter = Dokter::where('email', $credentials['email'])->first();

        if ($dokter && Hash::check($credentials['password'], $dokter->password)) {
            Auth::login($dokter);
            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('success', 'Selamat Datang, dr! '. $dokter->nama_dokter);
        }

        return back()->withErrors(['email' => 'Email atau Password Dokter salah.'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}