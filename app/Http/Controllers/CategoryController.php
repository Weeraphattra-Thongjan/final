<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    // แสดงรายการหมวดหมู่ทั้งหมด
    public function index()
    {
        abort_unless(Auth::user()?->role === 'admin', 403);

        $categories = Category::orderBy('name')->get();
        return view('admin.categories.index', compact('categories'));
    }

    // ฟอร์มเพิ่มหมวดหมู่
    public function create()
    {
        abort_unless(Auth::user()?->role === 'admin', 403);
        return view('admin.categories.create');
    }

    // บันทึกหมวดหมู่ใหม่
    public function store(Request $request)
{
    abort_unless(Auth::user()?->role === 'admin', 403);

    $data = $request->validate([
        'name' => 'required|string|max:255|unique:categories,name',
        'slug' => 'required|string|max:255|unique:categories,slug',
    ]);

    // 👉 ตรงนี้คือจุดที่เพิ่มบรรทัดนั้น
    $category = Category::create($data);
    $justId = $category->id; // ← id ที่เพิ่งสร้างจริง

    // (ถ้าอยากดูค่า ลอง dd($justId); ดูได้เลย)

    return redirect()
        ->route('admin.categories.index')
        ->with('success', 'เพิ่มหมวดหมู่เรียบร้อยแล้ว (ID: '.$justId.')');
}


    // ฟอร์มแก้ไขหมวดหมู่
    public function edit(Category $category)
    {
        abort_unless(Auth::user()?->role === 'admin', 403);
        return view('admin.categories.edit', compact('category'));
    }

    // บันทึกการแก้ไข
    public function update(Request $request, Category $category)
    {
        abort_unless(Auth::user()?->role === 'admin', 403);

        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'slug' => 'required|string|max:255|unique:categories,slug,' . $category->id,
        ]);

        $category->update($data);
        return redirect()->route('admin.categories.index')->with('success', 'แก้ไขหมวดหมู่เรียบร้อยแล้ว');
    }

    // ลบหมวดหมู่
    public function destroy(Category $category)
    {
        abort_unless(Auth::user()?->role === 'admin', 403);
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'ลบหมวดหมู่เรียบร้อยแล้ว');
    }
}
