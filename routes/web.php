<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AuthController;
use \App\Http\Controllers\AdminController;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\StafController;
use \App\Http\Controllers\CustomerController;
use \App\Http\Controllers\ProdukController;
use \App\Http\Controllers\PublicController;
use \App\Http\Controllers\TransaksiController;
use \App\Http\Controllers\JadwalController;
use \App\Http\Controllers\LaporanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// PUBLIC GUEST ROUTING  
Route::get('/', [PublicController::class, 'index']);
Route::get('/p/produk', [PublicController::class, 'produk_view']);
// AUTH ROUTING
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/act_login', [AuthController::class, 'authenticate'])->name('act_login');
Route::get('/register', [AuthController::class, 'register_view'])->name('register');
Route::post('/act_register', [AuthController::class, 'act_register'])->name('act-register');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['role:customer'])->group(function(){
    Route::get('profil', [PublicController::class, 'profil'])->name('profil');
    Route::get('keranjang', [PublicController::class, 'keranjang'])->name('keranjang');
    Route::get('/add_keranjang/{id}', [PublicController::class, 'add_keranjang'])->name('add_keranjang');
    Route::post('/update_keranjang/{id}', [PublicController::class, 'update_keranjang'])->name('update-qty-barang');
    Route::get('/delete_keranjang/{id}', [PublicController::class, 'delete_keranjang'])->name('keranjang-delete-barang');
    Route::get('/checkout', [PublicController::class, 'checkout'])->name('checkout');
    Route::post('/do_checkout', [PublicController::class, 'do_checkout'])->name('do_checkout');
    Route::get('/transaksi', [PublicController::class, 'transaksi'])->name('transaksi');
    Route::post('/bayar_transaksi', [PublicController::class, 'transaksi_upload_pembayaran'])->name('bayar-transaksi');
    Route::get('konfirmasi_penerimaan/{invoice}', [PublicController::class, 'konfirmasi_transaksi']);
});



// ADMIN ROUTING
Route::middleware('role:admin')->group(function(){
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // master data user
    Route::get('/admin/pengguna', [UserController::class, 'index']);
    Route::post('/admin/pengguna/insert', [UserController::class, 'insert_user']);
    Route::post('/admin/pengguna/edit', [UserController::class, 'update_user']);
    Route::get('/admin/pengguna/hapus/{id}', [UserController::class, 'delete_user']);

    // master data staf
    Route::get('/staf', [StafController::class, 'index'])->name('staf');
    Route::post('/staf/insert', [StafController::class, 'insert_staf'])->name('staf-insert');
    Route::post('/staf/update', [StafController::class, 'update_staf'])->name('staf-update');
    Route::get('/staf/delete/{id}', [StafController::class, 'delete_staf'])->name('staf-update');


    // master data customer
    Route::get('/customer', [CustomerController::class, 'index'])->name('customer');
    Route::post('/customer/insert', [CustomerController::class, 'insert_customer'])->name('customer-insert');
    Route::post('/customer/update', [CustomerController::class, 'update_customer'])->name('customer-update');
    Route::get('/customer/delete/{id}', [CustomerController::class, 'delete_customer'])->name('customer-update');


    // master data produk
    Route::get('/produk', [ProdukController::class, 'index'])->name('produk');
    Route::post('/produk/insert', [ProdukController::class, 'insert_produk'])->name('produk-insert');
    Route::post('/produk/update', [ProdukController::class, 'update_produk'])->name('produk-update');
    Route::get('/produk/delete/{id}', [ProdukController::class, 'delete_produk'])->name('produk-update');


    // transaksi
    Route::get('/a/transaksi', [TransaksiController::class, 'index'])->name('admin-transaksi');
    Route::get('/terima_pesanan/{invoice}', [TransaksiController::class, 'terima_transaksi']);
    Route::get('/batalkan_pesanan/{invoice}', [TransaksiController::class, 'batalkan_transaksi']);

    // jadwal
    Route::get('/a/jadwal', [JadwalController::class, 'index']);

    // laporan
    Route::get('/a/laporan_transaksi', [LaporanController::class, 'laporan_transaksi'])->name('laporan');
    Route::get('/a/laporan_penjualan', [LaporanController::class, 'laporan_penjualan'])->name('laporan-penjualan');
});


Route::get('/home', function(){
    return redirect('/');
})->name('home');
// Route::resource('/user','userController');
// Route::get('/user/hapus/{id}','userController@destroy');
// // Route::resource('/staf','stafController');
// // Route::get('/staf/hapus/{id}','stafController@destroy');
// Route::resource('/produk','produkController');
// Route::get('/produk/hapus/{id}','produkController@destroy');
// Route::resource('/customer','customerController');
// Route::get('/customer/hapus/{id}','customerController@destroy');