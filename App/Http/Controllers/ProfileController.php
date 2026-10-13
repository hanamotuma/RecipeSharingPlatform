<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
     public function index()
    {
        return Inertia::render('Profile', [
            'user' => Auth::user()
        ]);
    }
    public function show(User $user)
    {
       
        $recipes = $user->recipes()
            ->with(['category', 'likes'])
            ->withCount(['likes', 'comments'])
            ->latest()
            ->get();

        return Inertia::render('Profile/Show', [
            'profileUser' => $user,
            'recipes' => $recipes,
            'stats' => [
                'recipes_count' => $user->recipes()->count(),
                'likes_count' => $user->likes()->count(),
                'favorites_count' => $user->favorites()->count(),
            ]
        ]);
    }

    public function edit()
    {
        $user = Auth::user();
        return Inertia::render('Profile/Edit', [
            'user' => $user
        ]);
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
    $user = Auth::user();
    
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'bio' => 'nullable|string|max:500',
            'image' => 'nullable|image|max:2048', 
            
        ]);
        

     // Image Upload
    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('profile-photos', 'public');
        $user->profile_photo_path = $path; 
    }

    // Update text fields
    $user->fill($validated);
    $user->save();

    return back()->with('message', 'Profile updated successfully!');
}
}