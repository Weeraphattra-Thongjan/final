<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;
use App\Models\Category;

class PostController extends Controller
{
    /**
     * แสดงรายการโพสต์ทั้งหมด
     */
    public function index()
    {
        $posts = Post::with(['user','category'])->latest()->paginate(10);
        return view('posts.index', compact('posts'));
    }

    /**
     * แสดงฟอร์มสร้างโพสต์ใหม่
     */
    public function create()
    {
        // ส่งรายการหมวดหมู่ไปที่ฟอร์ม
        $categories = Category::orderBy('name')->get();
        return view('posts.create', compact('categories'));
    }

    /**
     * บันทึกโพสต์ใหม่
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'content'     => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['title','content','category_id']);
        $data['user_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('posts', 'public');
        }

        Post::create($data);

        return redirect()->route('posts.index')->with('success', 'สร้างโพสต์ใหม่เรียบร้อยแล้ว!');
    }

    /**
     * แสดงโพสต์เดียว
     */
    public function show($id)
    {
        $post = Post::with(['user','category'])->findOrFail($id);
        return view('posts.show', compact('post'));
    }

    /**
     * แสดงฟอร์มแก้ไขโพสต์
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::orderBy('name')->get();
        return view('posts.edit', compact('post','categories'));
    }

    /**
     * อัปเดตโพสต์
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'content'     => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'nullable|image|max:2048',
        ]);

        $post = Post::findOrFail($id);

        // อนุญาต: เจ้าของโพสต์หรือแอดมิน
        if ($post->user_id !== Auth::id() && optional(Auth::user())->role !== 'admin') {
            abort(403, 'คุณไม่มีสิทธิ์แก้ไขโพสต์นี้');
        }

        $data = $request->only(['title','content','category_id']);

        if ($request->hasFile('image')) {
            if ($post->image_path) {
                Storage::disk('public')->delete($post->image_path);
            }
            $data['image_path'] = $request->file('image')->store('posts', 'public');
        }

        $post->update($data);

        return redirect()->route('posts.index')->with('success', 'แก้ไขโพสต์เรียบร้อยแล้ว!');
    }

    /**
     * ลบโพสต์
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        // ตรวจสิทธิ์: ต้องเป็นเจ้าของโพสต์ หรือเป็น admin
        if ($post->user_id !== Auth::id() && optional(Auth::user())->role !== 'admin') {
            abort(403, 'คุณไม่มีสิทธิ์ลบโพสต์นี้');
        }

        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'ลบโพสต์เรียบร้อยแล้ว!');
    }
}
