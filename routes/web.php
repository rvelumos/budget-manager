<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BudgetController;
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
use App\Http\Controllers\CategoryController;
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

    Route::resource('expense-listings', ExpenseListingController::class);
    Route::resource('incomes-listings', IncomeListingController::class);

    Route::resource('expenses', ExpenseController::class);
    Route::resource('incomes', IncomeController::class);

    Route::resource('transactions', TransactionController::class);
    Route::get('transactions/import', [TransactionController::class, 'import'])->name('transactions.import');
    Route::post('transactions/import', [TransactionController::class, 'storeImport'])->name('transactions.storeImport');

    Route::resource('budgets', BudgetController::class);

    Route::get('forecast', [ForecastController::class, 'index'])->name('forecast');
    Route::get('account/settings', [UserController::class, 'settings'])->name('account.settings');

    Route::middleware('admin')->group(function () {
        Route::get('admin/', [AdminController::class, 'adminOverview'])->name('admin.index');
        //Route::get('admin/users', [AdminController::class, 'userOverview'])->name('admin.users');
        //Route::get('admin/settings', [AdminController::class, 'settings'])->name('admin.settings');

        Route::resource('/admin/categories', CategoryController::class);
    });
});


