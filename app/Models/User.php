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
        'phone',  // เพิ่มฟิลด์เบอร์โทร
        'avatar', // เพิ่มฟิลด์รูปโปรไฟล์
        'role',
    ];

    // ฟิลด์ที่ไม่ต้องการแสดง
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function isAdmin()
    {
        return $this->role === 'admin'; // ตรวจสอบว่าผู้ใช้เป็น admin หรือไม่
    }

    public function getAvatarUrlAttribute()
    {
        // ถ้ามีอัปโหลดรูปจริง → ใช้รูปจาก storage
        if ($this->avatar) {
         return asset('storage/' . $this->avatar);
        }

        // ถ้าไม่มี → ใช้รูปเริ่มต้น
        return asset('images/default-avatar.png');
    }
}

