<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()
                         ->with('error_title', 'Login Gagal')
                         ->with('error', 'Silakan periksa kembali email atau password Anda.');
        }

        if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'Email atau password tidak valid.'])->onlyInput('email')
                         ->with('error_title', 'Login Gagal')
                         ->with('error', 'Kredensial tidak valid.');
        }

        $request->session()->regenerate();
        $user = $request->user();

        if ($user->hasRole('admin')) {
            return back()->with('auth_success', 'Login berhasil sebagai admin.')
                         ->with('redirect_url', route('admin.dashboard'));
        }

        return back()->with('auth_success', 'Login berhasil.')
                     ->with('redirect_url', route('home'));
    }

    public function register(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                         ->withInput()
                         ->with('error_title', 'Registrasi Gagal')
                         ->with('error', 'Silakan periksa kembali data Anda.');
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone ?? null,
                'password' => Hash::make($request->password),
            ]);

            $user->assignRole('user');

            Auth::login($user);
            $request->session()->regenerate();

            return back()->with('auth_success', 'Registrasi berhasil. Selamat datang!')
                         ->with('redirect_url', route('home'));
        } catch (\Exception $e) {
            return back()->withInput()
                         ->with('error_title', 'Registrasi Gagal')
                         ->with('error', 'Terjadi kesalahan pada sistem.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Anda berhasil logout.');
    }
}