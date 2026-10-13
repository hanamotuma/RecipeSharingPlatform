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
                'likes_count' => \App\Models\Like::whereHas('recipe', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })->count(),
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
            'current_password' => 'nullable|required_with:new_password|current_password',
            'new_password' => 'nullable|required_with:current_password|confirmed|min:8',
        ]);

        // Profile photo upload
        if ($request->hasFile('image')) {
            if ($user->profile_photo_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->profile_photo_path);
            }
            $validated['profile_photo_path'] = $request->file('image')->store('profile-photos', 'public');
        }

        // Password change (only when a new password was supplied)
        if ($request->filled('new_password')) {
            $validated['password'] = Hash::make($validated['new_password']);
        }

        unset($validated['image'], $validated['current_password'], $validated['new_password']);

        $user->fill($validated);
        $user->save();

        return back()->with('message', 'Profile updated successfully!');
    }
}