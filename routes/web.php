<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;

// Halaman Beranda Utama
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route Khusus Tamu (Yang belum login)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Route KETAT Khusus Siswa yang Sudah Login
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Katalog, Peminjaman, dan Pengembalian Buku
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::post('/books/{id}/borrow', [BookController::class, 'borrow'])->name('books.borrow');
    Route::get('/my-loans', [BookController::class, 'myLoans'])->name('loans.index');
    Route::post('/loans/{id}/return', [BookController::class, 'returnBook'])->name('books.return');
});