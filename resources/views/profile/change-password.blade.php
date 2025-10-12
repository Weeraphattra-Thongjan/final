@extends('layout')

@section('content')
    <h2>เปลี่ยนรหัสผ่าน</h2>

    <form action="{{ route('profile.updatePassword') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="current_password">รหัสผ่านปัจจุบัน</label>
            <input type="password" name="current_password" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="new_password">รหัสผ่านใหม่</label>
            <input type="password" name="new_password" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="new_password_confirmation">ยืนยันรหัสผ่านใหม่</label>
            <input type="password" name="new_password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">บันทึกการเปลี่ยนรหัสผ่าน</button>
    </form>
@endsection
