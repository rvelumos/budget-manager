<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('home');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/account', [UserController::class, 'account'])->name('user.account');
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');

    Route::get('/budget', [IncomeController::class, 'budgetOverview'])->name('budget.index');

    Route::resource('budget/income', PostController::class);
    Route::resource('budget/expense', PostController::class);
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/users', [AdminController::class, 'manageUsers'])->name('admin.users');

    Route::get('/admin/categories', [CategoryController::class, 'manageCategories'])->name('admin.categories');
    Route::resource('/admin/category', PostController::class);

    Route::post('/admin/category', [CategoryController::class, 'insertCategory'])->name('admin.new_category');
});
