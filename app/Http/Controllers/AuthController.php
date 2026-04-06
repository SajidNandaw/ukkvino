<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LOGIN PAGE
    |--------------------------------------------------------------------------
    */
    public function login()
    {
        return view('auth.login');
    }

    /*
    |--------------------------------------------------------------------------
    | PROSES LOGIN
    |--------------------------------------------------------------------------
    */
    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email','password');

        if(Auth::attempt($credentials)){
            $user = Auth::user();

            // CEK STATUS USER
            if($user->status !== 'aktif'){
                Auth::logout();
                // GANTI back() jadi redirect login biar CSRF token aman
                return redirect()->route('login')
                                 ->with('error','Akun anda dinonaktifkan');
            }

            // REDIRECT ROLE
            if($user->role == 'admin'){
                return redirect()->route('admin.dashboard');
            }

            if($user->role == 'petugas'){
                return redirect()->route('petugas.dashboard');
            }

            return redirect()->route('user.dashboard');
        }

        return redirect()->route('login')->with('error','Email atau password salah');
    }

    /*
    |--------------------------------------------------------------------------
    | REGISTER PAGE
    |--------------------------------------------------------------------------
    */
    public function register()
    {
        return view('auth.register');
    }

    /*
    |--------------------------------------------------------------------------
    | PROSES REGISTER
    |--------------------------------------------------------------------------
    */
    public function registerPost(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'alamat' => $request->alamat ?? '',
            'password' => Hash::make($request->password),
            'role' => 'user',
            'status' => 'aktif'
        ]);

        return redirect()->route('login')->with('success','Registrasi berhasil, silahkan login');
    }

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}