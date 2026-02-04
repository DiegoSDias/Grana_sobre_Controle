<?php

use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\RegisterUserController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MonthsController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');
Route::get('/register', [RegisterUserController::class, 'index'])->name('register.index');
Route::post('/register', [RegisterUserController::class, 'store'])->name('register.store');

Route::middleware('auth')->group( function() {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('months/{year}/{month}', [MonthsController::class, 'show'])->name('month.show');
    Route::post('months/{year}/{month}', [MonthsController::class, 'close'])->name('month.close');
    Route::resource('expenses', ExpensesController::class);
    Route::resource('categories', CategoriesController::class);

});

