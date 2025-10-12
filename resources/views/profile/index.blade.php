@extends('layout')

@section('content')
    <div class="container mt-5 d-flex flex-column" style="height: 100vh;">
        <h2 class="text-center mb-4" style="font-size: 2rem;">โปรไฟล์ของคุณ</h2> <!-- ปรับขนาดตัวอักษร -->

        <div class="text-center">
            <!-- รูปโปรไฟล์ -->
            <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="rounded-circle" width="250" />
        </div>

        <div class="profile-info mt-4 text-center" style="font-size: 1.25rem;"> <!-- เพิ่มขนาดตัวอักษร -->
            <p><strong>ชื่อ:</strong> {{ $user->name }}</p>
            <p><strong>อีเมล์:</strong> {{ $user->email }}</p>
            <p><strong>เบอร์โทรศัพท์:</strong> {{ $user->phone }}</p>
        </div>

        <div class="text-center mt-4">
            <!-- ปุ่มแก้ไขโปรไฟล์และเปลี่ยนรหัสผ่าน -->
            <a href="{{ route('profile.edit') }}" class="btn btn-secondary btn-lg">แก้ไขโปรไฟล์</a> <!-- ปรับขนาดปุ่ม -->
            <a href="{{ route('profile.changePassword') }}" class="btn btn-warning btn-lg">เปลี่ยนรหัสผ่าน</a> <!-- ปรับขนาดปุ่ม -->
        </div>

        <div class="mt-auto text-center">
            <!-- ฟอร์มออกจากระบบ -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger btn-lg">ออกจากระบบ</button> <!-- ปรับขนาดปุ่ม -->
            </form>
        </div>
    </div>
@endsection
