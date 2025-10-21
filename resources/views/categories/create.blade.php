@extends('layout')

@section('content')
<div class="container mt-5">
  <h2 class="mb-4">เพิ่มหมวดหมู่ใหม่</h2>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('categories.store') }}" method="POST">
    @csrf
    <div class="mb-3">
      <label for="name" class="form-label">ชื่อหมวดหมู่</label>
      <input type="text" name="name" id="name" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="slug" class="form-label">Slug (ใช้ใน URL)</label>
      <input type="text" name="slug" id="slug" class="form-control" required>
      <div class="form-text">เช่น: "tech", "study", "travel"</div>
    </div>

    <button type="submit" class="btn btn-primary">บันทึก</button>
    <a href="{{ route('categories.index') }}" class="btn btn-secondary">กลับ</a>
  </form>
</div>
@endsection
