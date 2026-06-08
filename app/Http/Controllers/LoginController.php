<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    // ===== TAMBAHKAN METHOD INI =====
    
    /**
     * Method yang dipanggil setelah login berhasil
     */
    protected function authenticated(Request $request, $user)
    {
        // Redirect berdasarkan role
        if ($user->role === 'admin') {
            return redirect()->route('admin.admin');
        }
        
        // Untuk user biasa, redirect ke home
        return redirect()->route('home');
    }
    
    /**
     * Path default setelah login (fallback)
     */
    protected $redirectTo = '/home';
    
    // ... method lainnya
}