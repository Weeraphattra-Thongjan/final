@extends('layout')

@section('content')
<div class="container">
    <h2>โปรไฟล์ของคุณ</h2>
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">ชื่อ</label>
            <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" required>
        </div>

        <div class="form-group">
            <label for="email">อีเมล์</label>
            <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}" required>
        </div>

        <div class="form-group">
            <label for="phone">เบอร์โทรศัพท์</label>
            <input type="text" name="phone" class="form-control" value="{{ Auth::user()->phone }}" required>
        </div>

        <div class="form-group">
            <label for="avatar">รูปโปรไฟล์</label>
            <input type="file" name="avatar" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">บันทึกโปรไฟล์</button>
    </form>
</div>
@endsection
