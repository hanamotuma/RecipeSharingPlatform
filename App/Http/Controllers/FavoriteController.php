<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth; 

class FavoriteController extends Controller
{
    public function toggle(Recipe $recipe)
    {
        $user = Auth::user(); 
        
        if (!$user) {
            return redirect()->route('login');
        }
        $favorite = $recipe->favorites()->where('user_id', $user->id)->first();

        if ($favorite) {
            $favorite->delete();
            $favorited = false;
            $message = 'Recipe removed from favorites';
        } else {
            $recipe->favorites()->create(['user_id' => $user->id]); 
            $favorited = true; 
            $message = 'Recipe added to favorites!';
        }

        return redirect()->back()->with([
            'success' => $message,
            'favorited' => $favorited 
        ]);
    }
    
   
     public function index()
{
   /** @var \App\Models\User $user */
$user = Auth::user();

$favorites = $user->favorites()
    ->with(['recipe.user', 'recipe.category'])
    ->paginate(12);
}
}