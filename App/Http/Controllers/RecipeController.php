<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; 
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{
    use AuthorizesRequests; 
    public function create()
{
    return Inertia::render('Recipes/Create', [
        'categories' => Category::all()  
    ]);
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'ingredients' => 'required',
            'instructions' => 'required',
            'cooking_time' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
            'difficulty' => 'required|in:easy,medium,hard',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('recipes', 'public');
            $validated['image'] = $path;
        }

        $validated['user_id'] = Auth::id();

        Recipe::create($validated); 
        return redirect()->route('recipes.index')->with('success', 'Recipe created successfully!');
    }

   public function index(Request $request)
{
    $query = Recipe::with(['user', 'category'])
        ->withCount(['likes', 'comments']);
  
    if ($request->search && $request->search !== '') {
        $searchTerm = '%' . $request->search . '%';
        $query->where(function ($q) use ($searchTerm) {
            $q->where('title', 'like', $searchTerm)
              ->orWhere('description', 'like', $searchTerm)
              ->orWhere('ingredients', 'like', $searchTerm);
        });
    }

    if ($request->category && $request->category !== '') {
        $query->where('category_id', $request->category);
    }

    switch ($request->sort) {
        case 'popular':
            $query->orderBy('likes_count', 'desc');
            break;
        case 'oldest':
            $query->orderBy('created_at', 'asc');
            break;
        default:
            $query->orderBy('created_at', 'desc');
    }

    $recipes = $query->paginate(12);

    return Inertia::render('Recipes/Index', [
        'recipes' => $recipes,
        'categories' => Category::all(),
        'filters' => $request->only(['search', 'category', 'sort'])
    ]);
}

    public function show(Recipe $recipe)
    {
        $recipe->load(['user', 'category', 'comments.user']);
        $recipe->loadCount(['likes', 'comments']);

        $user = Auth::user();
        
        return Inertia::render('Recipes/Show', [
            'recipe' => $recipe,
            'isLiked' => $user ? $recipe->isLikedBy($user) : false,
            'isFavorited' => $user ? $recipe->isFavoritedBy($user) : false,
            'shareUrl' => url()->current(),
        ]);
    }

    public function update(Request $request, Recipe $recipe)
    {
        $this->authorize('update', $recipe);

        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'ingredients' => 'required',
            'instructions' => 'required',
            'cooking_time' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
            'difficulty' => 'required|in:easy,medium,hard',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($recipe->image) {
                Storage::disk('public')->delete($recipe->image);
            }
            $validated['image'] = $request->file('image')->store('recipes', 'public');
        } else {
            unset($validated['image']); 
        }

        $recipe->update($validated);

        return redirect()->route('recipes.show', $recipe)->with('success', 'Recipe updated successfully!');
    }

    public function destroy(Recipe $recipe)
    {
        $this->authorize('delete', $recipe);

        if ($recipe->image) {
            Storage::disk('public')->delete($recipe->image);
        }

        $recipe->delete();

        return redirect()->route('recipes.index')->with('success', 'Recipe deleted successfully!');
    }
}