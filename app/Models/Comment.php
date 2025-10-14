<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'image', 'home_id', 'user_id'];

    public function home()
{
    return $this->belongsTo(Home::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}

}
