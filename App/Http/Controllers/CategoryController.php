<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('recipes')->get();

        return Inertia::render('Categories/Index', [
            'categories' => $categories
        ]);
    }

    public function show(Category $category)
    {
        $recipes = $category->recipes()
            ->with(['user', 'category'])
            ->withCount(['likes', 'comments'])
            ->latest()
            ->paginate(12);

        return Inertia::render('Categories/Show', [
            'category' => $category,
            'recipes' => $recipes
        ]);
    }
}