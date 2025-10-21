<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Home;

class HomePolicy
{
    public function create(User $user): bool
    {
        return $user !== null; // สมาชิกทุกคนที่ล็อกอิน โพสต์ได้
    }

    public function update(User $user, Home $home): bool
    {
        return $user->role === 'admin' || $home->user_id === $user->id;
    }

    public function delete(User $user, Home $home): bool
    {
        return $user->role === 'admin' || $home->user_id === $user->id;
    }
}
