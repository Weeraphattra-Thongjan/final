<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * แสดงหน้าโปรไฟล์
     */
    public function index()
    {
        // ดึงข้อมูลของผู้ใช้ที่เข้าสู่ระบบ
        $user = Auth::user();
        
        // ส่งข้อมูลผู้ใช้ไปยังหน้าโปรไฟล์
        return view('profile.index', compact('user'));
    }

    /**
     * แสดงฟอร์มแก้ไขโปรไฟล์
     */
    public function edit()
    {
        // ดึงข้อมูลผู้ใช้ที่เข้าสู่ระบบ
        $user = Auth::user();
        
        // ส่งข้อมูลไปยังฟอร์มแก้ไขโปรไฟล์
        return view('profile.edit', compact('user'));
    }

    /**
     * อัปเดตข้อมูลโปรไฟล์
     */
    public function update(Request $request)
    {
        // ตรวจสอบข้อมูลที่กรอก
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:15',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // ดึงข้อมูลผู้ใช้ที่เข้าสู่ระบบ
        $user = Auth::user();
        
        // อัปเดตข้อมูลที่ผู้ใช้กรอก
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        // อัปโหลดรูปโปรไฟล์ถ้ามี
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatar;
        }

        // บันทึกการเปลี่ยนแปลง
        $user->save();

        // เปลี่ยนเส้นทางกลับไปที่หน้าโปรไฟล์
        return redirect()->route('profile')->with('success', 'โปรไฟล์ของคุณได้รับการอัปเดต');
    }

    /**
     * แสดงฟอร์มเปลี่ยนรหัสผ่าน
     */
    public function changePassword()
    {
        return view('profile.change-password');
    }

    /**
     * อัปเดตการเปลี่ยนรหัสผ่าน
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        // ตรวจสอบรหัสผ่านปัจจุบัน
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'รหัสผ่านปัจจุบันไม่ถูกต้อง']);
        }

        // อัปเดตรหัสผ่านใหม่
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('profile')->with('success', 'รหัสผ่านของคุณได้รับการอัปเดต');
    }
}

