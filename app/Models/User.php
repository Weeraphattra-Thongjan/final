<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',   // เบอร์โทร
        'avatar',  // รูปโปรไฟล์ (path ใต้ storage/app/public)
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Accessor: เรียก $user->avatar_url เพื่อได้ URL ของรูปโปรไฟล์
     * - ถ้ามีไฟล์ที่อัปโหลด -> storage/<path>
     * - ถ้าไม่มี -> public/images/default-avatar.png
     */
    public function getAvatarUrlAttribute(): string
    {
        if (!empty($this->avatar)) {
            return asset('storage/' . ltrim($this->avatar, '/'));
        }

        // วางไฟล์รูปเริ่มต้นไว้ที่ public/images/default-avatar.png
        return asset('images/default-avatar.png');
    }
}
