@extends('layout')

@section('content')
    <div class="container">
        <h2>สมัครสมาชิก</h2>

        <!-- ฟอร์มการสมัครสมาชิก -->
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- ชื่อผู้ใช้ -->
            <div class="form-group">
                <label for="name">ชื่อ</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- อีเมล์ -->
            <div class="form-group mt-3">
                <label for="email">อีเมล์</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- รหัสผ่าน -->
            <div class="form-group mt-3">
                <label for="password">รหัสผ่าน</label>
                <input type="password" name="password" id="password" class="form-control" required>
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- ยืนยันรหัสผ่าน -->
            <div class="form-group mt-3">
                <label for="password_confirmation">ยืนยันรหัสผ่าน</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
            </div>

            <!-- ปุ่มสมัครสมาชิก -->
            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary">สมัครสมาชิก</button>
            </div>
        </form>

        <!-- ลิงก์ไปยังหน้าเข้าสู่ระบบ -->
        <div class="mt-3 text-center">
            <p>มีบัญชีอยู่แล้ว? <a href="{{ route('login') }}" class="btn btn-link">เข้าสู่ระบบ</a></p>
        </div>
    </div>
@endsection
