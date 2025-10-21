@extends('layout')

@section('content')
<h2 class="mb-4 fw-bold text-center">แก้ไขโพสต์</h2>

<form
  action="{{ route('posts.update', $home->id) }}"
  method="POST"
  enctype="multipart/form-data"
  class="mx-auto"
  style="max-width: 700px;"
>
  @csrf
  @method('PUT')

  <div class="mb-3">
    <label for="title" class="form-label">หัวข้อ</label>
    <input
      type="text"
      name="title"
      id="title"
      class="form-control"
      value="{{ old('title', $home->title) }}"
      required
    >
    @error('title') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  <div class="mb-3">
    <label for="content" class="form-label">รายละเอียด</label>
    <textarea
      name="content"
      id="content"
      class="form-control"
      rows="6"
      required
    >{{ old('content', $home->content) }}</textarea>
    @error('content') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  <div class="mb-3">
    <label for="category_id" class="form-label">หมวดหมู่</label>
    <select name="category_id" id="category_id" class="form-select" required>
      <option value="">-- เลือกหมวดหมู่ --</option>
      @foreach($categories as $category)
        @php
          // ให้เลือกหมวดเดิมถูกต้อง: ถ้าตาราง homes มี column category_id ใช้อันนั้น
          // หากไม่มี (เก็บชื่อหมวดใน column 'category') ให้เทียบชื่อ
          $selectedId = old('category_id');
          if (!$selectedId) {
            if (isset($home->category_id)) {
              $selectedId = $home->category_id;
            } elseif (isset($home->category) && $home->category === $category->name) {
              $selectedId = $category->id;
            }
          }
        @endphp
        <option value="{{ $category->id }}" {{ (string)$selectedId === (string)$category->id ? 'selected' : '' }}>
          {{ $category->name }}
        </option>
      @endforeach
    </select>
    @error('category_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  <div class="mb-3">
    <label for="image" class="form-label">อัพโหลดรูปใหม่ (ถ้าต้องการเปลี่ยน)</label>
    <input type="file" name="image" id="image" class="form-control">
    @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror

    @if ($home->image)
      <div class="mt-2">
        <p class="text-muted small mb-1">รูปปัจจุบัน:</p>
        <img src="{{ asset('storage/'.$home->image) }}" alt="post image" style="max-width:200px;border-radius:8px;">
      </div>
    @endif
  </div>

  <div class="mt-4 d-flex gap-2">
    <button type="submit" class="btn btn-primary">บันทึกการแก้ไข</button>
  </div>
</form>

<style>
  .btn-primary{
    background:linear-gradient(90deg,#8B5CF6,#EC4899);
    border:none;font-weight:600;border-radius:999px;padding:10px 22px;
    box-shadow:0 3px 10px rgba(139,92,246,.4);
  }
  .btn-primary:hover{background:linear-gradient(90deg,#7C3AED,#DB2777);box-shadow:0 6px 14px rgba(139,92,246,.5)}
</style>
@endsection
