<?php

namespace App\Http\Controllers;

use App\Models\Home;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * หน้าแรก: แสดงโพสต์ทั้งหมด (public)
     */
    public function index()
{
    $posts = Home::with('user')->withCount('comments')->latest()->paginate(10);

    $categories = Cache::remember('homepage.categories', 300, function () {
        return Category::orderBy('name')->get(['id','name','slug']);
    });

    return view('index', compact('posts', 'categories'));
}

    /**
     * ฟอร์มสร้างโพสต์ (ต้องล็อกอิน)
     */
    public function create()
    {
        $categories = \App\Models\Category::orderBy('name')->get(['id','name','slug']);
    return view('create', compact('categories'));
    }

    /**
     * แสดงโพสต์เดี่ยว (public)
     */
    public function show(Home $home)
    {
        // ดึงโพสต์พร้อมผู้เขียน
        $home->load('user')->loadCount('comments');

        // ดึงคอมเมนต์เรียงล่าสุด พร้อมผู้คอมเมนต์
        $comments = $home->comments()
            ->with('user')
            ->latest()
            ->get();

        return view('show', [
            'home'     => $home,
            'comments' => $comments,
        ]);
    }

    /**
     * บันทึกโพสต์ใหม่ (ต้องล็อกอิน)
     */
    public function store(Request $request)
    {
        $this->authorize('create', Home::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content'  => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'image'       => 'nullable|image|max:4096',
        ]);

        $post = new \App\Models\Home();
        $post->title   = $validated['title'];
        $post->content = $validated['content'];
        $post->user_id = auth()->id();

        // ถ้าใช้โครงสร้างที่เก็บชื่อหมวดไว้ในคอลัมน์ 'category'
        if (!empty($validated['category_id'])) {
            $cat = \App\Models\Category::find($validated['category_id']);
            $post->category = $cat?->name; 
        } else {
            $post->category = null;
        }

        // ✅ อัปโหลดรูปลง disk 'public' แล้วเก็บพาธสัมพัทธ์ เช่น posts/xxx.jpg
        if ($request->hasFile('image')) {
            $post->image = $request->file('image')->store('posts', 'public');
        }

        $post->save();

        return redirect()->route('posts.show', $post)->with('success', 'สร้างโพสต์แล้ว');
    }

    /**
     * ฟอร์มแก้ไขโพสต์ (ต้องเป็นเจ้าของโพสต์)
     */
    public function edit(Home $home)
    {
        $this->authorize('update', $home);

        $categories = \App\Models\Category::orderBy('name')->get(['id','name','slug']);
        $selectedId = \App\Models\Category::where('name', $home->category)->value('id'); // อาจเป็น null

        return view('edit', compact('home','categories','selectedId'));
    }

    /**
     * อัปเดตโพสต์ (ต้องเป็นเจ้าของโพสต์)
     */
    public function update(Request $request, Home $home)
    {
        $this->authorize('update', $home);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content'  => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'image'       => 'nullable|image|max:4096',
        ]);

        $home->title   = $validated['title'];
        $home->content = $validated['content'];

        if (!empty($validated['category_id'])) {
            $cat = \App\Models\Category::find($validated['category_id']);
            $home->category = $cat?->name;
        } else {
            $home->category = null;
        }

        // ✅ ลบรูปเก่า (ถ้ามี) แล้วอัปโหลดใหม่ลง disk 'public'
        if ($request->hasFile('image')) {
            if ($home->image) {
                Storage::disk('public')->delete($home->image);
            }
            $home->image = $request->file('image')->store('posts', 'public');
        }

        $home->save();
        return redirect()->route('posts.show', $home)->with('success', 'แก้ไขโพสต์แล้ว');
    }

    /**
     * ลบโพสต์ (ต้องเป็นเจ้าของโพสต์)
     */
    public function destroy(Home $home)
    {
        $this->authorize('delete', $home);
        $home->delete();
        return redirect()->route('index')->with('success', 'ลบโพสต์แล้ว');
    }

    /**
     * เพิ่มคอมเมนต์ใต้โพสต์ (ต้องล็อกอิน)
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
 * แก้ไขคอมเมนต์ (เฉพาะเจ้าของคอมเมนต์)
 */
public function updateComment(Request $request, Home $home, Comment $comment)
{
    // อนุญาตเฉพาะเจ้าของคอมเมนต์and_admin
    abort_unless(Auth::id() === $comment->user_id || optional(Auth::user())->role === 'admin', 403);

    $validated = $request->validate([
        'content' => ['required', 'string'],
        'image'   => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
    ]);

    // อัปเดตข้อความ
    $comment->content = $validated['content'];

    // ถ้ามีอัปโหลดรูปใหม่ — ลบรูปเก่า (ถ้ามี) แล้วบันทึกรูปใหม่
    if ($request->hasFile('image')) {
        if (!empty($comment->image)) {
            Storage::disk('public')->delete($comment->image);
        }
        $comment->image = $request->file('image')->store('comment_images', 'public');
    }

    $comment->save();

    return back()->with('success', 'แก้ไขคอมเมนต์เรียบร้อยแล้ว');
}

    /**
     * ลบคอมเมนต์ (เจ้าของคอมเมนต์หรือเจ้าของโพสต์)
     */
    public function destroyComment(Home $home, Comment $comment)
{
    abort_unless(
        Auth::id() === $comment->user_id || Auth::id() === $home->user_id || optional(Auth::user())->role === 'admin',
        403
    );

    $comment->delete();

    return back()->with('success', 'ลบคอมเมนต์เรียบร้อยแล้ว');
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
            ->paginate(10);

        return view('categories.show', compact('category', 'posts'));
    }

    public function myPosts()
    {
        $posts = Home::with('user')->withCount('comments')
            ->where('user_id', auth()->id())
            ->latest()->paginate(10);

        return view('my-posts', compact('posts'));
    }
}
