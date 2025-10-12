@extends('layout') <!-- ใช้ layout หลักของคุณ -->

@section('content')
    <div class="container">
        <h2>ลืมรหัสผ่าน</h2>

        <!-- แสดงข้อความสถานะถ้ามี -->
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <!-- ฟอร์มขอรีเซ็ตรหัสผ่าน -->
        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group">
                <label for="email">อีเมล์</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary">ส่งลิงก์รีเซ็ตรหัสผ่าน</button>
            </div>
        </form>
    </div>
@endsection
