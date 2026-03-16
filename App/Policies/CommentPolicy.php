<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;

class CommentPolicy
{
    public function delete(User $user, Comment $comment)
    {
       
        $isAuthor = $user->id === $comment->user_id;
        $isRecipeOwner = $user->id === $comment->recipe->user_id;

        return $isAuthor || $isRecipeOwner;
    }
}