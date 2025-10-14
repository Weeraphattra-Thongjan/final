<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'string', 'max:15'],  //การตรวจสอบเบอร์โทรศัพท์
        ]);

        // สร้างผู้ใช้ใหม่
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $request->phone, // บันทึกเบอร์โทรศัพท์
        ]);

        // เข้าสู่ระบบผู้ใช้หลังจากสมัคร
        auth()->login($user);

        // เปลี่ยนเส้นทางไปที่หน้าแรก (หรือหน้าอื่นๆ ตามต้องการ)
        return redirect()->route('index');
    }
}
