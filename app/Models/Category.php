<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Category extends Model
{
    protected $fillable = ['name','slug'];

    protected static function booted()
    {
        static::saved(function () { Cache::forget('homepage.categories'); });
        static::deleted(function () { Cache::forget('homepage.categories'); });
    }
}
