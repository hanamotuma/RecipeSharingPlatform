<?php

namespace App\Models;

use App\Models\Recipe;
use App\Models\Favorite;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    
    use HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password',
        'bio',
        'profile_photo_path',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts=[
    
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    public function recipes()
{
    return $this->hasMany(Recipe::class);
}
public function comments(){
    return $this->hasMany(Comment::class);
}
public function likes()
    {
        return $this->hasMany(Like::class);
    }

   public function favorites()
{
    return $this->hasMany(\App\Models\Favorite::class);
}
}
