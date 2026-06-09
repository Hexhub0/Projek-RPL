<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\GeminiChatController;

Route::post('/gemini/chat', [GeminiChatController::class, 'chat'])->name('gemini.chat');

Route::get('/chat', function () {
    return view('chat');
})->name('chat');


Route::get('/', function () {
    return view('app');
})->name('Login');

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/menu', function () {
    return view('menu');
})->name('menu');

Route::get('/produk', function () {
    return view('produk');
})->name('produk');

Route::get('/order', function () {
    return view('order-history');
})->name('order history');

Route::get('/checkout', function () {
    return view('checkout');
})->name('checkout');


Route::get('/admin', function () {
    return view('admin.admin');
});

Route::get('/admin/menu', function () {
    return view('admin.menu.admin_menu');
});

Route::get('/admin/transaksi', function () {
    return view('admin.transaksi.admin_transaksi');
});