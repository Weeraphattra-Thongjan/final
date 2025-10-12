<?php
// เอาไว้แสดงหน้าแว็บ

namespace App\Http\Controllers;

use App\Models\home;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //แสดงหน้าแรก
        $posts = Home::all(); // ดึงข้อมูลโพสต์ทั้งหมด
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
        // ตรวจสอบข้อมูลที่กรอกในฟอร์ม
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // สร้างโพสต์ใหม่
        Home::create([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        // เปลี่ยนเส้นทางไปที่หน้า index พร้อมกับข้อความ success
        return redirect()->route('index')->with('success', 'โพสต์ถูกสร้างแล้ว');

    }

    /**
     * Display the specified resource.
     */
    public function show(home $home)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(home $home)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, home $home)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(home $home)
    {
        //
    }
}
