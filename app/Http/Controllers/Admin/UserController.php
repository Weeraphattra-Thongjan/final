<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // store new admin-managed user
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255|unique:users,name',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:50',
            'avatar'=> 'nullable|string',
        ]);

        $avatar = $validated['avatar'] ?? null;
        if ($avatar && !file_exists(public_path($avatar))) {
            $avatar = null;
        }

        // สร้างผู้ใช้ใหม่ (ตั้งรหัสผ่านสุ่มแบบชั่วคราว)
        $password = Str::random(12);
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'phone'    => $validated['phone'] ?? null,
            'avatar'   => $avatar,
            'password' => Hash::make($password),
            'role'     => 'user',
        ]);

        // (เลือก) คุณอาจส่งอีเมลแจ้งรหัสผ่านหรือให้เปลี่ยนรหัสผ่านครั้งแรก

        return redirect()->route('admin.dashboard')->with('user_success', 'เพิ่มผู้ใช้เรียบร้อยแล้ว');
    }

    // update user
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:users,name,' . $user->id,
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone'    => 'nullable|string|max:50',
            'avatar'   => 'nullable|string',
        ]);

        $avatar = $validated['avatar'] ?? null;
        if ($avatar && !file_exists(public_path($avatar))) {
            $avatar = null;
        }

        $user->name  = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;
        $user->avatar = $avatar;
        $user->save();

        return redirect()->route('admin.dashboard')->with('user_success', 'อัปเดตข้อมูลผู้ใช้แล้ว');
    }

    // delete user
    public function destroy(User $user)
    {
        // ป้องกันไม่ให้แอดมินลบตัวเอง (ถ้าต้องการ)
        if (auth()->check() && auth()->id() === $user->id) {
            return redirect()->route('admin.dashboard')->with('user_success', 'ไม่สามารถลบผู้ใช้ตัวเองได้');
        }

        $user->delete();
        return redirect()->route('admin.dashboard')->with('user_success', 'ลบผู้ใช้แล้ว');
    }
}