<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    use HasFactory;

    // กำหนดให้เป็น fillable เพื่ออนุญาตให้เพิ่มข้อมูลเหล่านี้ได้
    protected $fillable = ['title', 'content'];
}
