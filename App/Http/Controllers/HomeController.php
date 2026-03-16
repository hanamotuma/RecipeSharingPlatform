<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {

        $categories = Category::withCount('recipes')->get();
        $featuredRecipes = Recipe::with(['user', 'category'])
            ->withCount(['likes', 'comments'])
            ->latest()
            ->limit(3)
            ->get();

        return Inertia::render('Home', [
            'categories' => $categories,
            'featuredRecipes' => $featuredRecipes
        ]);
    }
}