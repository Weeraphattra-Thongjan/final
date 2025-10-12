<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'category', 'image', 'user_id'];

    /**
     * โพสจะมีหลายคอมเม้นต์
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * โพสมีผู้ใช้งาน
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
