<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    // View registered books
    Route::get('/dashboard', [BookController::class, 'index'])->name('dashboard');
    
    // Register a book
    Route::post('/books', [BookController::class, 'store'])->name('books.store');
});
