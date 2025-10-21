<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Home; // ✅ ใช้ Home (ไม่ใช่ Post)

class ProfileController extends Controller
{
    public function __construct()
    {
        // ใช้ middleware auth ผ่าน route group ก็พอ
        // ถ้าเว็บคุณไม่ใช้ Kernel แบบปกติของ Laravel 12+ แล้ว error ตรงนี้
        // สามารถลบทิ้ง/คอมเมนต์บรรทัดนี้ได้
        // $this->middleware('auth');
    }

    /**
     * หน้าโปรไฟล์: แสดงรายการโพสต์ของเรา
     */
    public function index()
    {
        $user = Auth::user();

        // ✅ ดึงโพสต์ของผู้ใช้ + นับคอมเมนต์ ผ่าน relation 'comments' ที่เพิ่งแก้ให้ใช้ home_id
        $posts = Home::with('user')
            ->withCount('comments')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('profile.index', compact('user', 'posts'));
    }

    /**
     * แก้ไขข้อมูลส่วนตัว (ฟอร์ม)
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * อัปเดตข้อมูลส่วนตัว
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'phone' => ['nullable', 'string', 'max:50'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'], // สำหรับเลือกจาก preset
            'avatar_upload' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'], // สำหรับอัพโหลดเอง
        ]);

        // จัดการ avatar
        if ($request->hasFile('avatar_upload')) {
            // ถ้ามีการอัพโหลดไฟล์ใหม่
            $path = $request->file('avatar_upload')->store('avatars', 'public');
            $user->avatar = 'storage/' . $path;
        } elseif ($request->filled('avatar')) {
            // ถ้าเลือกจาก preset
            $user->avatar = $request->avatar;
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
        $user->save();

        return back()->with('success', 'อัปเดตโปรไฟล์เรียบร้อยแล้ว');
    }

    /**
     * ฟอร์มเปลี่ยนรหัสผ่าน
     */
    public function passwordForm()
    {
        return view('profile.password');
    }

    /**
     * อัปเดตรหัสผ่าน
     */
    public function passwordUpdate(Request $request)
    {
        $request->validate([
            'password' => ['required','confirmed','min:8'],
        ]);

        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->route('profile')->with('success', 'เปลี่ยนรหัสผ่านแล้ว');
    }
}
