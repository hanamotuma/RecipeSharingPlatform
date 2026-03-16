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
             'bio' => 'nullable|string|max:500',
            'current_password' => 'nullable|required_with:new_password|current_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

       // Update basic info
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->bio = $validated['bio'] ?? null;

        // Update password if provided
        if ($request->filled('new_password')) {
            $user->password = Hash::make($validated['new_password']);
        }

        $user->save();

        return redirect()->route('profile.show', $user->id)->with('success', 'Profile updated successfully!');
    }
}