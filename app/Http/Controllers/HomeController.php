<?php

namespace App\Http\Controllers;

use App\Models\Home;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * หน้าแรก: แสดงโพสต์ทั้งหมดพร้อมผู้โพสต์และจำนวนคอมเมนต์
     */
    public function index()
    {
        $posts = Home::with('user')
            ->withCount('comments')
            ->latest()
            ->get();

        return view('index', compact('posts'));
    }

    /**
     * ฟอร์มสร้างโพสต์ (route: posts.create)
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('create', compact('categories'));
    }

    /**
     * แสดงโพสต์เดี่ยว (route: posts.show)
     */
    public function show(Home $home)
    {
        $home->load(['user', 'comments.user'])->loadCount('comments');

        return view('show', compact('home'));
    }

    /**
     * บันทึกโพสต์ใหม่ (route: posts.store)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'content'     => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'image'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
        ]);

        $category = Category::findOrFail($validated['category_id']);

        $home = new Home();
        $home->title    = $validated['title'];
        $home->content  = $validated['content'];
        $home->category = $category->name;
        $home->user_id  = Auth::id();

        if ($request->hasFile('image')) {
            $home->image = $request->file('image')->store('home_images', 'public');
        }

        $home->save();

        return redirect()
            ->route('posts.show', ['home' => $home->id])
            ->with('success', 'โพสต์ของคุณถูกสร้างเรียบร้อยแล้ว');
    }

    /**
     * ฟอร์มแก้ไขโพสต์ (route: posts.edit)
     */
    public function edit(Home $home)
    {
        abort_unless($home->user_id === Auth::id(), 403);

        $categories = Category::orderBy('name')->get();

        return view('edit', compact('home', 'categories'));
    }

    /**
     * อัปเดตโพสต์ (route: posts.update)
     */
    public function update(Request $request, Home $home)
    {
        abort_unless($home->user_id === Auth::id(), 403);

        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'content'     => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'image'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
        ]);

        $category = Category::findOrFail($validated['category_id']);

        $home->title    = $validated['title'];
        $home->content  = $validated['content'];
        $home->category = $category->name;

        if ($request->hasFile('image')) {
            $home->image = $request->file('image')->store('home_images', 'public');
        }

        $home->save();

        return redirect()
            ->route('posts.show', ['home' => $home->id])
            ->with('success', 'โพสต์ของคุณได้รับการอัปเดตแล้ว');
    }

    /**
     * ลบโพสต์ (route: posts.destroy)
     */
    public function destroy(Home $home)
    {
        abort_unless($home->user_id === Auth::id(), 403);

        $home->delete();

        return redirect()
            ->route('index')
            ->with('success', 'โพสต์ของคุณถูกลบแล้ว');
    }

    /**
     * เพิ่มคอมเมนต์ใต้โพสต์ (route: comment.store)
     */
    public function storeComment(Request $request, Home $home)
    {
        $validated = $request->validate([
            'content' => ['required', 'string'],
            'image'   => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
        ]);

        $comment = new Comment();
        $comment->content = $validated['content'];
        $comment->home_id = $home->id;
        $comment->user_id = Auth::id();

        if ($request->hasFile('image')) {
            $comment->image = $request->file('image')->store('comment_images', 'public');
        }

        $comment->save();

        return redirect()
            ->route('posts.show', ['home' => $home->id])
            ->with('success', 'คอมเมนต์ของคุณถูกเพิ่มเรียบร้อย');
    }

    /**
     * แสดงโพสต์ตามหมวดหมู่ (public)
     */
    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $posts = Home::where('category', $category->name)
            ->with('user')
            ->withCount('comments')
            ->latest()
            ->get();

        return view('categories.show', compact('category', 'posts'));
    }
}
