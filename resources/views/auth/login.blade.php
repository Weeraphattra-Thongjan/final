@extends('layout') <!-- ใช้ layout หลักของคุณ -->

@section('content')
    <div class="container">
        <h2 class="mb-4">เข้าสู่ระบบ</h2>

        <!-- ตรวจสอบข้อความสถานะจาก session -->
        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <!-- ฟอร์มการเข้าสู่ระบบ -->
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email">อีเมล</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label for="password">รหัสผ่าน</label>
                <input type="password" name="password" id="password" class="form-control" required>
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember me -->
            <div class="form-check mt-3">
                <input type="checkbox" name="remember" id="remember" class="form-check-input">
                <label for="remember" class="form-check-label">จดจำฉัน</label>
            </div>

            <div class="form-group mt-20">
                <button type="submit" class="btn btn-primary">เข้าสู่ระบบ</button>
            </div>

            <!-- ลืมรหัสผ่าน -->
            @if (Route::has('password.request'))
                <div class="mt-3">
                    <a href="{{ route('password.request') }}" class="text-sm">ลืมรหัสผ่าน?</a>
                </div>
            @endif
        </form>

        <!-- ลิงก์ไปยังหน้าสมัครสมาชิก -->
        <div class="mt-4 text-center">
            <p>ยังไม่มีบัญชี? <a href="{{ route('register') }}" class="btn btn-link">สมัครสมาชิก</a></p>
        </div>
    </div>
@endsection
