<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AdminController extends Controller
{

    public function manageUsers(): View|Factory|Application
    {
        $users = User::paginate(10); // Paginate for performance
        return view('admin.users.index', compact('users'));
    }

    public function manageCategories(): View|Factory|Application
    {
        $categories = Category::paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function editCategory(Category $category): View|Factory|Application
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function updateCategory(Request $request, Category $category): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:expense,income',
        ]);

        $category->update($request->all());

        return redirect()->route('admin.categories.index')
            ->with('success', __('categories.updated'));
    }

    public function deleteCategory(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', __('categories.deleted'));
    }

    public function runReports(): View|Factory|Application
    {
        $totalIncome = Transaction::where('type', 'income')->sum('amount');
        $totalExpense = Transaction::where('type', 'expense')->sum('amount');

        return view('admin.reports.index', compact('totalIncome', 'totalExpense'));
    }
}
