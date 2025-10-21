<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // ปรับตามฟิลด์บทบาทของโปรเจ็กต์คุณ ถ้าใช้ 'is_admin' ก็แก้เงื่อนไขนี้
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'คุณไม่มีสิทธิ์เข้าถึงส่วนแอดมิน');
        }
        return $next($request);
    }
}
