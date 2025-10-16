<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    use HasFactory;

    // ถ้า table ชื่อ homes ก็ไม่ต้องใส่ $table; ถ้าเป็นชื่ออื่นค่อยกำหนด
    // protected $table = 'homes';

    protected $fillable = [
        'title', 'content', 'category', 'image', 'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🔧 สำคัญ: ใช้ foreign key = home_id
    public function comments()
    {
        return $this->hasMany(Comment::class, 'home_id');
    }
}
