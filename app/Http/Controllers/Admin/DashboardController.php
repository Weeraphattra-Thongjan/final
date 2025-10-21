<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        // ดึงหมวดหมู่ล่าสุดพร้อมแบ่งหน้า ใช้ endpoint เดิมของ CategoryController ในการบันทึก/แก้ไข/ลบ
        $categories = Category::latest()->paginate(12);

        // สามารถส่งสถิติอื่น ๆ เพิ่มได้ เช่นจำนวนโพสต์/คอมเมนต์ ฯลฯ
        return view('admin.dashboard', compact('categories'));
    }
}
