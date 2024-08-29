<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ExpenseListingController;
use App\Http\Controllers\IncomeListingController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('index');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/account', [UserController::class, 'account'])->name('user.account');
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');

    Route::resource('/income-listings', ExpenseListingController::class);
    Route::resource('/income-listings.expenses', ExpenseController::class);

    Route::resource('/expense-listings', IncomeListingController::class);
    Route::resource('/expense-listings.expenses', IncomeController::class);
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/users', [AdminController::class, 'manageUsers'])->name('admin.users');

    Route::get('/admin/categories', [CategoryController::class, 'manageCategories'])->name('admin.categories');
    Route::resource('/admin/category', PostController::class);

    Route::post('/admin/category', [CategoryController::class, 'insertCategory'])->name('admin.new_category');
});
