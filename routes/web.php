<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ExpenseListingController;
use App\Http\Controllers\IncomeListingController;
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

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('expenses', ExpenseController::class);
    Route::resource('income', IncomeController::class);
    Route::get('transactions/import', [TransactionController::class, 'import'])->name('transactions.import');
    Route::get('forecast', [ForecastController::class, 'index'])->name('forecast');
    Route::get('account/settings', [AccountController::class, 'settings'])->name('account.settings');

    Route::middleware('admin')->group(function () {
        Route::get('admin/users', [AdminController::class, 'userOverview'])->name('admin.users');
        Route::get('admin/settings', [AdminController::class, 'settings'])->name('admin.settings');

        Route::get('/admin/categories', [CategoryController::class, 'manageCategories'])->name('admin.categories');
        Route::resource('/admin/category', PostController::class);
    });
});
