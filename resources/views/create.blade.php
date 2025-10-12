@extends('layout')

@section('content')
<form action="{{ route('store')}}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="title">หัวข้อ</label>
        <input type="text" name="title" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="content">เนื้อหา</label>
        <textarea name="content" class="form-control" rows="5" rowrequired></textarea>
    </div>
    <button type="submit" class="btn btn-success"> สร้างกระทู้ </button>
    <a href="{{ route('index')}}" class="btn btn-secondary"> ย้อนกลับ</a>
</form>
    
@endsection