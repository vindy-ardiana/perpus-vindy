<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AuthManualController extends Controller
{
    //LOGIN
    public function index()
    {
        return view('manual-auth.login');
    }

    //REGISTRASI
    public function registrasi()
    {
         return view('manual-auth.registrasi');
    }

    public function registrasiProses(Request $request)
    {
        $validated =  $request->validate([
            'nama' => 'required',
            'email' => 'required|email', 
            'password' => 'required',
        ]);

        User::create([
            'name' => $validated['nama'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
        ]);
        return redirect()->route('login');

    }

    public function loginProses(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ],[
            'email.required' => 'Email harus diisi!',
            'email.email' => 'Format email harus benar.',
            'password.required' => 'Password wajib diisi!',


        ]);

        if (Auth::attempt($credentials)) {
             $request->session()->regenerate();
             //cek role user : 
             // admin user petugas
             Alert::success('Selamat!', 'Anda telah berhasil masuk ke sistem!');
            if(Auth::user()->role != 'admin'){
                return redirect()->route('user.dashboard');
            }
           
            // Alert::success('Selamat!', 'Anda telah berhasil masuk ke sistem!');
            return redirect()->route('dashboard');
        }

        // Alert::alert('Gagal Login', 'Username atau Password anda salah', 'error');
        // Alert::error(Gagal Login', 'username atau Password anda salah');
        Alert::toast('Username atau Password anda salah', 'error')->autoClose(3000);
        return back();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Alert::toast('Anda telah logout!', 'success')->autoClose(3000);
        return redirect()->route('login');
    }
}
