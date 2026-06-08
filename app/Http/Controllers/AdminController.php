<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin');
    }

    public function transaksi()
    {
        // Implementasi untuk halaman transaksi
        return view('admin.transaksi');
    }
}