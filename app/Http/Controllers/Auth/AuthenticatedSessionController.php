<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    // แสดงหน้าเข้าสู่ระบบ
    public function create()
    {
        return view('auth.login');
    }

    // บันทึกการเข้าสู่ระบบ
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            // ถ้าผู้ใช้เข้าสู่ระบบสำเร็จ ให้ redirect ไปที่หน้าหลัก
            return redirect()->intended('/');
        }

        // ถ้าผู้ใช้เข้าสู่ระบบไม่สำเร็จ ให้โยนข้อผิดพลาด
        throw ValidationException::withMessages([
            'email' => ['ข้อมูลเข้าสู่ระบบไม่ถูกต้อง'],
        ]);
    }

    // ฟังก์ชันออกจากระบบ
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
