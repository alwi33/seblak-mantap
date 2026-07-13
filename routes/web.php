<?php

use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KondimenController;
use App\Http\Controllers\Admin\PaketController;
use App\Http\Controllers\Admin\PemesananController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\Auth\LoginController as CustomerLoginController;
use App\Http\Controllers\Auth\RegisterController as CustomerRegisterController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController as CustomerDashboardController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\StatusPesananController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman Pelanggan (Customer, tanpa login / guest)
|--------------------------------------------------------------------------
*/
Route::get('/', [MenuController::class, 'index'])->name('menu.index');

Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
Route::post('/keranjang/tambah', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
Route::post('/keranjang/{id}/update', [KeranjangController::class, 'update'])->name('keranjang.update');
Route::delete('/keranjang/{id}', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');

Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

Route::get('/pembayaran/{kode}', [PembayaranController::class, 'show'])->name('pembayaran.show');
Route::post('/pembayaran/{kode}/upload', [PembayaranController::class, 'upload'])->name('pembayaran.upload');

Route::get('/cek-status', [StatusPesananController::class, 'form'])->name('status.form');
Route::post('/cek-status', [StatusPesananController::class, 'cek'])->name('status.cek');

/*
|--------------------------------------------------------------------------
| Akun Pelanggan (opsional - login, daftar, dashboard pelanggan)
|--------------------------------------------------------------------------
| Ini TERPISAH sepenuhnya dari login admin di bawah. Akun yang dibuat lewat
| /register TIDAK PERNAH mendapat akses ke /admin/* - itu hanya untuk akun
| yang kolom is_admin-nya true (lihat middleware EnsureUserIsAdmin).
*/
Route::get('/login', [CustomerLoginController::class, 'showLoginForm'])->name('customer.login');
Route::post('/login', [CustomerLoginController::class, 'login'])->name('customer.login.submit');
Route::post('/logout', [CustomerLoginController::class, 'logout'])->name('customer.logout');

Route::get('/register', [CustomerRegisterController::class, 'showRegisterForm'])->name('customer.register');
Route::post('/register', [CustomerRegisterController::class, 'register'])->name('customer.register.submit');

Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->middleware('auth')->name('dashboard');

/*k
|--------------------------------------------------------------------------
| Login Admin
|--------------------------------------------------------------------------
| Route ini sengaja diberi nama 'login' supaya middleware 'auth' bawaan
| Laravel otomatis mengarahkan ke sini kalau ada yang belum login mencoba
| membuka halaman /admin/*. (Lihat bootstrap/app.php: redirectGuestsTo)
*/
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Panel Admin (butuh login DAN is_admin = true)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('paket', PaketController::class)->except(['show']);
    Route::resource('kondimen', KondimenController::class)
    ->except(['show'])
    ->parameters(['kondimen' => 'kondimen']);

    Route::get('/pemesanan', [PemesananController::class, 'index'])->name('pemesanan.index');
    Route::get('/pemesanan/{pemesanan}', [PemesananController::class, 'show'])->name('pemesanan.show');
    Route::post('/pemesanan/{pemesanan}/konfirmasi-bayar', [PemesananController::class, 'konfirmasiBayar'])->name('pemesanan.konfirmasi-bayar');
    Route::post('/pemesanan/{pemesanan}/update-status', [PemesananController::class, 'updateStatus'])->name('pemesanan.update-status');

    Route::get('/pengaturan', [PengaturanController::class, 'edit'])->name('pengaturan.edit');
    Route::put('/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');
});
