<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // ดึงหมวดหมู่ล่าสุดพร้อมแบ่งหน้า
        $categories = Category::latest()->paginate(12);

        // ดึงผู้ใช้สำหรับตารางผู้ใช้ในหน้าแดชบอร์ด
        $users = User::latest()->paginate(12);

        // validation errors ของการเพิ่ม/แก้ไขผู้ใช้ (ถ้ามี) จะอยู่ใน session('errors')
        $userErrors = session('errors');

        // สามารถส่งสถิติอื่น ๆ เพิ่มได้ เช่นจำนวนโพสต์/คอมเมนต์ ฯลฯ
        return view('admin.dashboard', compact('categories', 'users', 'userErrors'));
    }
}
