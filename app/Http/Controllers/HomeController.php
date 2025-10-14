<?php

namespace App\Http\Controllers;

use App\Models\Home;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * แสดงโพสต์พร้อมกับผู้โพสต์และคอมเมนต์
     */
    public function index()
    {
        // ดึงข้อมูลโพสพร้อมกับข้อมูลผู้โพสและคอมเมนต์
        $posts = Home::with('user', 'comments')->get();

        // ส่งข้อมูลไปที่หน้า index.blade.php
        return view('index', compact('posts'));
    }

    /**
     * ฟอร์มสร้างโพสต์
     */
    public function create()
    {
        return view('create'); // หน้าฟอร์มการสร้างโพสต์
    }

    public function show($home_id)
    {
        $home = Home::findOrFail($home_id);
        return view('show', compact('home'));
    }


    /**
     * สร้างโพสต์ใหม่
     */
    public function store(Request $request)
    {
        // ตรวจสอบข้อมูลจากฟอร์ม
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'nullable|string', // ตรวจสอบ category
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // รองรับการอัปโหลดรูป
        ]);

        // สร้างโพสต์ใหม่
        $home = new Home();
        $home->title = $request->title;
        $home->content = $request->content;
        $home->category = $request->category;

        // การอัปโหลดรูปภาพ
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('home_images', 'public');
            $home->image = $imagePath;
        }

        $home->save();

        return redirect()->route('index')->with('success', 'โพสต์ของคุณถูกสร้างเรียบร้อยแล้ว');
    }

    /**
     * ฟอร์มแก้ไขโพสต์
     */
    public function edit(Home $home)
    {
        return view('home.edit', compact('home'));
    }

    /**
     * อัปเดตโพสต์
     */
    public function update(Request $request, Home $home)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|string',
        ]);

        // อัปเดตโพสต์
        $home->title = $request->title;
        $home->content = $request->content;
        $home->category = $request->category;

        // อัปเดตการอัปโหลดรูปภาพถ้ามี
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('home_images', 'public');
            $home->image = $imagePath;
        }

        $home->save();

        return redirect()->route('index')->with('success', 'โพสต์ของคุณได้รับการอัปเดต');
    }

    /**
     * ลบโพสต์
     */
    public function destroy(Home $home)
    {
        $home->delete();

        return redirect()->route('index')->with('success', 'โพสต์ของคุณถูกลบแล้ว');
    }

    /**
     * เพิ่มคอมเมนต์
     */
    public function storeComment(Request $request, Home $home)
    {
        $request->validate([
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // รองรับการอัปโหลดรูปในคอมเมนต์
        ]);

        // สร้างคอมเมนต์ใหม่
        $comment = new Comment();
        $comment->content = $request->content;
        $comment->home_id = $home->id; // ใช้ home_id สำหรับคอมเมนต์
        $comment->user_id = Auth::id(); // ผู้ตอบ

        // การอัปโหลดรูปภาพในคอมเมนต์
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('comment_images', 'public');
            $comment->image = $imagePath;
        }

        $comment->save();

        return back()->with('success', 'คอมเมนต์ของคุณถูกเพิ่มเรียบร้อย');
    }

    
}
