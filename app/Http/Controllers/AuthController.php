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
        $messages = [
            'email.required' => 'Email tidak boleh kosong.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password tidak boleh kosong.',
        ];

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], $messages);

        if ($validator->fails()) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first()
                ], 422);
            }
            return back()->withErrors($validator)->withInput()
                         ->with('error_title', 'Validasi Gagal');
        }

        if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email atau password tidak valid.'
                ], 401);
            }
            return back()->withErrors(['email' => 'Email atau password tidak valid.'])->onlyInput('email')
                         ->with('error_title', 'Login Gagal');
        }

        $request->session()->regenerate();
        $user = $request->user();

        if ($user->hasRole('admin')) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Login berhasil sebagai admin.',
                    'redirect_url' => route('admin.dashboard')
                ]);
            }
            return redirect()->route('admin.dashboard')->with('success', 'Login berhasil sebagai admin.');
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Login berhasil.',
                'redirect_url' => route('home')
            ]);
        }
        return redirect()->route('home')->with('success', 'Login berhasil.');
    }

    public function register(Request $request)
    {
        $messages = [
            'name.required' => 'Nama lengkap tidak boleh kosong.',
            'name.max' => 'Nama lengkap maksimal 100 karakter.',
            'email.required' => 'Email tidak boleh kosong.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 150 karakter.',
            'email.unique' => 'Email sudah terdaftar. Silakan gunakan email lain.',
            'phone.max' => 'Nomor handphone maksimal 20 digit.',
            'password.required' => 'Password tidak boleh kosong.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Password dan Konfirmasi Password tidak sama.',
            'terms.required' => 'Anda harus menyetujui syarat dan ketentuan.',
        ];

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'terms' => ['required'],
        ], $messages);

        if ($validator->fails()) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first()
                ], 422);
            }
            return back()->withErrors($validator)
                         ->withInput()
                         ->with('error_title', 'Validasi Gagal');
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

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Registrasi berhasil. Selamat datang!',
                    'redirect_url' => route('home')
                ]);
            }
            return redirect()->route('home')->with('success', 'Registrasi berhasil. Selamat datang!');
        } catch (\Exception $e) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan pada sistem.'
                ], 500);
            }
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