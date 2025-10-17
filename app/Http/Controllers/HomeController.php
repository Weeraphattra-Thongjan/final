<?php

namespace App\Http\Controllers;

use App\Models\Home;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * หน้าแรก: แสดงโพสต์ทั้งหมด (public)
     */
    public function index()
    {
        $posts = Home::with('user')
            ->withCount('comments')
            ->latest()
            ->paginate(10); // แบ่งหน้าให้ลื่นขึ้น (ปรับจำนวนได้)

        return view('index', compact('posts'));
    }

    /**
     * ฟอร์มสร้างโพสต์ (ต้องล็อกอิน)
     */
    public function create()
    {
        $categories = Category::all(); // ดึงข้อมูลจากตาราง categories
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
     * ฟอร์มแก้ไขโพสต์ (ต้องเป็นเจ้าของโพสต์)
     */
    public function edit(Home $home)
    {
        abort_unless($home->user_id === Auth::id() || Auth::user()->role === 'admin', 403);

        $categories = Category::orderBy('name')->get();
        return view('edit', compact('home', 'categories'));
    }

    /**
     * อัปเดตโพสต์ (ต้องเป็นเจ้าของโพสต์)
     */
    public function update(Request $request, Home $home)
    {
        abort_unless($home->user_id === Auth::id() || Auth::user()->role === 'admin', 403);

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
     * ลบโพสต์ (ต้องเป็นเจ้าของโพสต์)
     */
    public function destroy(Home $home)
    {
        abort_unless($home->user_id === Auth::id() || Auth::user()->role === 'admin', 403);

        $home->delete();

        return redirect()
            ->route('index')
            ->with('success', 'โพสต์ของคุณถูกลบแล้ว');
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
}
