@extends('layout')

@section('content')
<h2 class="mb-4 fw-bold text-center">
  {{ isset($post) ? 'แก้ไขโพสต์' : 'สร้างโพสต์ใหม่' }}
</h2>

<form
  action="{{ isset($post) ? route('posts.update', $post->id) : route('posts.store') }}"
  method="POST"
  enctype="multipart/form-data"
  class="mx-auto"
  style="max-width: 700px;"
>
  @csrf
  @if(isset($post))
    @method('PUT')
  @endif

  <div class="mb-3">
    <label for="title" class="form-label">หัวข้อ</label>
    <input
      type="text"
      name="title"
      id="title"
      class="form-control"
      value="{{ old('title', $post->title ?? '') }}"
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
    >{{ old('content', $post->content ?? '') }}</textarea>
    @error('content') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  <div class="mb-3">
    <label for="category_id" class="form-label">หมวดหมู่</label>
    <select name="category_id" id="category_id" class="form-select" required>
      <option value="">-- เลือกหมวดหมู่ --</option>
      @foreach($categories as $category)
        <option value="{{ $category->id }}"
          {{ old('category_id', isset($post) ? optional(\App\Models\Category::where('name', $post->category)->first())->id : null) == $category->id ? 'selected' : '' }}>
          {{ $category->name }}
        </option>
      @endforeach
    </select>
    @error('category_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  <div class="mb-3">
    <label for="image" class="form-label">อัปโหลดรูป</label>
    <input type="file" name="image" id="image" class="form-control">
    @if(isset($post) && $post->image)
      <div class="mt-2">
        <img src="{{ asset('storage/'.$post->image) }}" alt="post image" class="rounded-3" style="max-width: 250px;">
      </div>
    @endif
    @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>


  <div class="mt-4 form-actions d-flex gap-2">
    <button type="submit" class="btn btn-primary">{{ isset($post) ? 'บันทึกการแก้ไข' : 'โพสต์' }}</button>
    <a href="{{ route('index') }}" class="btn btn-secondary">กลับ</a>
  </div>
</form>

<style>

  .btn-primary{
    background: linear-gradient(90deg,#8B5CF6,#EC4899);
    border: none; font-weight: 600; border-radius: 999px; padding: 10px 22px;
    box-shadow: 0 3px 10px rgba(139,92,246,.4);
  }
  .btn-primary:hover{
    background: linear-gradient(90deg,#7C3AED,#DB2777);
    box-shadow: 0 6px 14px rgba(139,92,246,.5);
  }


  .btn-secondary {
  background: #E9E9ED;
  color: #4B0082;
  font-weight: 500;
  border: none;
  border-radius: 999px;
  padding: 10px 22px;
  transition: all 0.3s ease;
}

.btn-secondary:hover {
  background: #D8BFD8; /* ม่วงพาสเทลจาง ๆ */
  color: white;
  box-shadow: 0 4px 10px rgba(139,92,246,0.2);
  transform: translateY(-2px);
}
  }


  .wetalk-fab, .floating-brand, [data-brand="wetalk"]{
    display: none !important;
  }
</style>
@endsection
