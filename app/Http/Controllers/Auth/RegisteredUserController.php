<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    // แสดงฟอร์มการสมัครสมาชิก
    public function create()
    {
        return view('auth.register'); // สร้างหน้า register.blade.php
    }

    // บันทึกการสมัครสมาชิก
    public function store(Request $request)
    {
        // ตรวจสอบข้อมูลที่กรอก
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'phone' => 'nullable|string|max:50',
            'avatar' => 'nullable|string',
        ]);

        $avatar = $request->input('avatar');
        if ($avatar && !file_exists(public_path($avatar))) {
            $avatar = null;
        }

        // สร้างผู้ใช้ใหม่
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'avatar' => $avatar,
            'password' => Hash::make($request->password),
        ]);

        // เข้าสู่ระบบผู้ใช้หลังจากสมัคร
        auth()->login($user);

        // เปลี่ยนเส้นทางไปที่หน้าแรก (หรือหน้าอื่นๆ ตามต้องการ)
        return redirect()->route('index');
    }
}
