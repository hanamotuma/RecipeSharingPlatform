<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Gate; 

class CommentController extends Controller
{
    public function store(Request $request, Recipe $recipe)
    {
        if (!Auth::check()) {
            return back()->with('error', 'You must be logged in to comment.');
        }

        $validated = $request->validate([
            'comment' => 'required|string|max:1000'
        ]);

        $recipe->comments()->create([
            'user_id' => Auth::id(), 
            'recipe_id' => $recipe->id,
            'comment' => $validated['comment']
        ]);

        return back()->with('success', 'Comment added successfully!');
    }

    public function destroy(Comment $comment)
    {
        
        Gate::authorize('delete', $comment);
            
        $comment->delete();

        return back()->with('success', 'Comment deleted successfully!');
    }
}