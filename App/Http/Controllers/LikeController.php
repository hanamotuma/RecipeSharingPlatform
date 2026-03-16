<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle(Recipe $recipe)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        $like = $recipe->likes()->where('user_id', $user->id)->first();

        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            $recipe->likes()->create(['user_id' => $user->id]);
            $liked = true;
            $message = 'Recipe liked!';
        }

      
        return redirect()->back()->with([
            'liked' => $liked,
            'likes_count' => $recipe->likes()->count()
        ]);
    }
}