<?php

namespace App\Http\Controllers;

abstract class Controller
{
    // Tambahkan method
public function redirectTo()
{
    if (Auth::user()->role === 'admin') {
        return '/admin/dashboard';
    }
    
    return '/home';
}
}
