@extends('layout')

@section('content')
    <h2>แก้ไขโปรไฟล์</h2>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">ชื่อ</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="form-group">
            <label for="email">อีเมล์</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="form-group">
            <label for="phone">เบอร์โทรศัพท์</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
        </div>

        <div class="form-group">
            <label for="avatar">รูปโปรไฟล์</label>
            <input type="file" name="avatar" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">บันทึกการเปลี่ยนแปลง</button>
    </form>
@endsection
