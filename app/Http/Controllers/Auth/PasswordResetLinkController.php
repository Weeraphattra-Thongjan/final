<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class PasswordResetLinkController extends Controller
{
    // แสดงฟอร์มขอรหัสผ่านใหม่
    public function create()
    {
        return view('auth.forgot-password');
    }

    // ส่งคำขอรีเซ็ตรหัสผ่าน
    public function store(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // ส่งลิงก์รีเซ็ตรหัสผ่าน
        $status = Password::sendResetLink($request->only('email'));

        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withErrors(['email' => __($status)]);
    }
}
