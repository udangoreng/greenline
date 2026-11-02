<?php
use App\Http\Controllers\ShopController as S;
use Illuminate\Support\Facades\Route;
Route::get('/', [S::class, 'home']);
Route::get('/produk', [S::class, 'index']);
Route::get('/produk/{product}', [S::class, 'show']);
Route::get('/keranjang', [S::class, 'cart']);
Route::post('/keranjang/tambah/{product}', [S::class, 'add']);
Route::post('/keranjang/ubah', [S::class, 'update']);
use App\Http\Controllers\AuthController as U;
Route::get('/masuk', [U::class, 'loginForm'])->name('login');
Route::post('/masuk', [U::class, 'login']);
Route::get('/daftar', [U::class, 'registerForm']);
Route::post('/daftar', [U::class, 'register']);
Route::post('/keluar', [U::class, 'logout']);
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [S::class, 'checkout']);
    Route::post('/checkout', [S::class, 'store']);
    Route::get('/pesanan', [S::class, 'orders']);
    Route::get('/pesanan/{order}', [S::class, 'order']);
});
Route::post('/midtrans/notify', [S::class, 'notify']);

use App\Http\Controllers\AdminController as A;
use App\Http\Middleware\AdminAuth;
Route::get('/admin/login', [A::class, 'loginForm']);
Route::post('/admin/login', [A::class, 'login']);
Route::middleware(AdminAuth::class)->prefix('admin')->group(function () {
    Route::get('/', [A::class, 'dashboard']);
    Route::post('/logout', [A::class, 'logout']);
    Route::get('/produk', [A::class, 'products']);
    Route::get('/produk/baru', [A::class, 'form']);
    Route::get('/produk/{product}/ubah', [A::class, 'form']);
    Route::post('/produk', [A::class, 'save']);
    Route::post('/produk/{product}', [A::class, 'save']);
    Route::delete('/produk/{product}', [A::class, 'destroy']);
    Route::get('/pesanan/{order}', [A::class, 'order']);
    Route::post('/pesanan/{order}', [A::class, 'updateOrder']);
});

Route::get('/sdg', fn() => view('sdg', ['groups' => \App\Models\Product::all()->groupBy('sdg')]));
