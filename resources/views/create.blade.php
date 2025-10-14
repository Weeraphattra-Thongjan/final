@extends('layout')

@section('content')
    <h2>สร้างโพสใหม่</h2>
    <form action="{{ route('store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">หัวข้อ</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="content">รายละเอียด</label>
            <textarea name="content" class="form-control" rows="5" required></textarea>
        </div>
        <div class="form-group">
            <label for="category">หมวดหมู่</label>
            <input type="text" name="category" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="image">อัพโหลดรูป</label>
            <input type="file" name="image" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">โพส</button>
        <a href="{{ route ('index') }}" class="btn btn-secondary"> Back </a>
    </form>
@endsection
