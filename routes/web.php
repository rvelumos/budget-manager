<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\UserController;
//use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ForecastController;
use App\Http\Controllers\ExpenseListingController;
use App\Http\Controllers\IncomeListingController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AuthController;

Route::middleware(['setLocale'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('locale/{lang}', function ($lang) {
        if (in_array($lang, ['en', 'nl'])) {
            session(['locale' => $lang]);
        }
        return redirect()->back();
    })->name('locale');
});

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    //Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::prefix('expense-listings')->group(function () {
        Route::resource('expense-listings', ExpenseListingController::class);
        Route::resource('expenses', ExpenseController::class);
        Route::get('{expenseList}/expenses', [ExpenseController::class, 'index'])->name('expense-listings.expenses.index');
    });

    Route::prefix('income-listings')->group(function () {
        Route::resource('expense-listings', ExpenseListingController::class);
        Route::resource('incomes', incomeController::class);
        Route::get('{incomeList}/incomes', [incomeController::class, 'index'])->name('income-listings.incomes.index');
    });

    Route::resource('transactions', TransactionController::class);
    Route::put('transactions/{transaction}/{type}', [TransactionController::class, 'update'])->name('transactions.update');
    Route::get('transactions/{type}/{id}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
    Route::delete('transactions/{type}/{id}', [TransactionController::class, 'destroy'])->name('transactions.destroy');

    Route::get('transactions/import', [TransactionController::class, 'import'])->name('transactions.import');
    Route::post('transactions/import', [TransactionController::class, 'storeImport'])->name('transactions.storeImport');

    Route::resource('budgets', BudgetController::class);

    Route::resource('forecasts', ForecastController::class);
    Route::get('account/settings', [UserController::class, 'settings'])->name('account.settings');

    Route::prefix('admin')->middleware(['auth', 'can:admin'])->group(function () {
        Route::get('users', [AdminController::class, 'manageUsers'])->name('admin.users.index');
        Route::get('categories', [CategoryController::class, 'manageCategories'])->name('admin.categories.index');
        Route::post('categories', [CategoryController::class, 'store'])->name('admin.categories.post');
        Route::get('categories/{category}/edit', [CategoryController::class, 'editCategory'])->name('admin.categories.edit');
        Route::put('categories/{category}', [CategoryController::class, 'updateCategory'])->name('admin.categories.update');
        Route::delete('categories/{category}', [CategoryController::class, 'deleteCategory'])->name('admin.categories.delete');
        Route::get('reports', [AdminController::class, 'runReports'])->name('admin.reports.index');
    });
});


