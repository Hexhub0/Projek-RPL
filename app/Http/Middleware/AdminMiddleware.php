<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $user = Auth::user();
        
        // 2. Cek apakah user memiliki role admin
        if ($user->role !== 'admin') {
            // Jika bukan admin, redirect ke home dengan pesan error
            return redirect()->route('home')->with('error', 'Anda tidak memiliki izin mengakses halaman admin.');
        }
        
        // 3. Jika admin, lanjutkan request
        return $next($request);
    }
}