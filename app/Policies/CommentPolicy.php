<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;

class CommentPolicy
{
    public function create(User $user): bool
    {
        return $user !== null; // สมาชิกทุกคนที่ล็อกอิน ตอบได้
    }

    public function update(User $user, Comment $comment): bool
    {
        return $user->role === 'admin' || $comment->user_id === $user->id;
    }

    public function delete(User $user, Comment $comment): bool
    {
        return $user->role === 'admin' || $comment->user_id === $user->id;
    }
}
