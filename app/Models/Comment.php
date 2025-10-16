<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content', 'image', 'home_id', 'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🔧 สำคัญ: ใช้ foreign key = home_id
    public function home()
    {
        return $this->belongsTo(Home::class, 'home_id');
    }
}
