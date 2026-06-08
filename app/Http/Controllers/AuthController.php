<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login
     */
    public function showLogin()
    {
        // Jika sudah login, redirect sesuai role
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }
        
        return view('app');
    }

    /**
     * Proses login
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            $redirectUrl = $user->role === 'admin' ? '/admin' : '/home';
            
            return response()->json([
                'success' => true,
                'message' => 'Login berhasil!',
                'redirect' => $redirectUrl
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Email atau password salah!'
        ], 401);
    }

    /**
     * Proses register
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'confirmPassword' => 'required|same:password',
        ], [
            'name.required' => 'Nama harus diisi',
            'name.string' => 'Nama harus berupa teks',
            'name.max' => 'Nama maksimal 255 karakter',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
            'confirmPassword.required' => 'Konfirmasi password harus diisi',
            'confirmPassword.same' => 'Konfirmasi password tidak sesuai',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'user', // Default role adalah user
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran berhasil! Silakan login dengan akun Anda.'
            ], 201);
        } catch (\Exception $e) {
            \Log::error('Registration Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.'
            ], 500);
        }
    }

    /**
     * Proses logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah berhasil logout');
    }

    /**
     * Helper method untuk redirect berdasarkan role
     */
    private function redirectBasedOnRole()
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            return redirect('/admin');
        }
        
        return redirect('/home');
    }

    /**
     * Forgot password (placeholder untuk implementasi nanti)
     */
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.exists' => 'Email tidak terdaftar',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        // TODO: Implement password reset logic
        // Untuk saat ini hanya return success message
        
        return response()->json([
            'success' => true,
            'message' => 'Link reset password telah dikirim ke email Anda!'
        ]);
    }
}