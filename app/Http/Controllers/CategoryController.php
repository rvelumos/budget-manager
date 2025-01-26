<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(): View|Factory|Application
    {
        $categories = Category::all();
        return view('category.index', compact('categories'));
    }

    public function create(): View|Factory|Application
    {
        return view('category.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        Category::create($request->all());

        return redirect()->route('category.index')
                         ->with('success', 'Category created successfully.');
    }

    public function show(Category $category): View|Factory|Application
    {
        return view('category.show', compact('category'));
    }

    public function edit(Category $category): View|Factory|Application
    {
        return view('category.edit', compact('category'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $category->update($request->all());

        return redirect()->route('category.index')
                         ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('category.index')
                         ->with('success', 'Category deleted successfully.');
    }
}
