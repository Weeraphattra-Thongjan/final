<?php
// เอาไว้แสดงหน้าแว็บ

namespace App\Http\Controllers;

use App\Models\home;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ดึงข้อมูลโพสพร้อมกับข้อมูลผู้โพสและคอมเมนต์
        $posts = Home::with('user', 'comments')->get();

        // ส่งข้อมูลไปที่หน้า index.blade.php
        return view('index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create'); // หน้าฟอร์มการสร้างโพสต์
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // ตรวจสอบข้อมูลจากฟอร์ม
    $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'category' => 'nullable|string', // ตรวจสอบ category
    ]);

    // สร้างโพสต์ใหม่
    Home::create([
        'title' => $request->title,
        'content' => $request->content,
        'category' => $request->category, // ใช้ category
    ]);

    // กลับไปที่หน้าหลักพร้อมข้อความ success
    return redirect()->route('index')->with('success', 'โพสต์ของคุณถูกสร้างเรียบร้อยแล้ว');
}



    /**
     * แสดงโพส.
     */
   public function show(Home $home)
    {
        return view('home.show', compact('home'));
    }

    /**
     *แก้ไขโพส
     */
    public function edit(Home $home)
    {
        return view('home.edit', compact('home'));
    }

    /**
     * อัปเดตโพส
     */
    public function update(Request $request, Home $home)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|string',
        ]);

        $home->title = $request->title;
        $home->content = $request->content;
        $home->category = $request->category;
        
        $home->save();

        return redirect()->route('index')->with('success', 'โพสของคุณได้รับการอัปเดต');
    }

    /**
     *  ลบโพส
     */
    public function destroy(Home $home)
    {
        $home->delete();

        return redirect()->route('index')->with('success', 'โพสของคุณถูกลบแล้ว');
    }

    /**
     * เพิ่มคอมเม้นต์
     */
    public function storeComment(Request $request, Home $home)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $comment = new Comment();
        $comment->content = $request->content;
        $comment->home_id = $home->id; // ใช้ home_id สำหรับคอมเม้นต์
        $comment->user_id = Auth::id(); // ผู้ตอบ
        $comment->save();

        return back()->with('success', 'คอมเม้นต์ของคุณถูกเพิ่มเรียบร้อย');
    }
}
