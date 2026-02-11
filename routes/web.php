<?php

use App\Http\Controllers\CategoryGroupController;
use App\Http\Controllers\MonthsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group( function() {
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');
    Route::get('months/{year}/{month}', [MonthsController::class, 'show'])->name('month.show');
    Route::post('months/{year}/{month}', [MonthsController::class, 'close'])->name('month.close');
    Route::resource('expenses', ExpensesController::class);
    Route::resource('categories', CategoriesController::class);
    Route::resource('category-groups', CategoryGroupController::class);


});

require __DIR__.'/auth.php';
