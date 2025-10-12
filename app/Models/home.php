<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'category', 'image', 'user_id'];

    /**
     * ความสัมพันธ์หนึ่งต่อหลาย (User - Home)
     */
    public function comments()
{
    return $this->hasMany(Comment::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}

}
