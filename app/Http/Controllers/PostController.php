<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post; // ต้องมีถ้ามีโมเดลชื่อ Post

class PostController extends Controller
{
    /**
     * แสดงรายการโพสต์ทั้งหมด
     */
    public function index()
    {
        $posts = Post::latest()->paginate(10);
        return view('posts.index', compact('posts'));
    }

    /**
     * แสดงฟอร์มสร้างโพสต์ใหม่
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * บันทึกโพสต์ใหม่
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Post::create($request->all());

        return redirect()->route('posts.index')->with('success', 'สร้างโพสต์ใหม่เรียบร้อยแล้ว!');
    }

    /**
     * แสดงโพสต์เดียว
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.show', compact('post'));
    }

    /**
     * แสดงฟอร์มแก้ไขโพสต์
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.edit', compact('post'));
    }

    /**
     * อัปเดตโพสต์
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post = Post::findOrFail($id);
        $post->update($request->all());

        return redirect()->route('posts.index')->with('success', 'แก้ไขโพสต์เรียบร้อยแล้ว!');
    }

    /**
     * ลบโพสต์
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'ลบโพสต์เรียบร้อยแล้ว!');
    }
}
