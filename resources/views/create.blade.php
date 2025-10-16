@extends('layout')

@section('content')
<style>
  body {
    background-color: #f4ebff; /* สีพื้นหลังอ่อนๆ ทั้งหน้า */
  }

  .create-container {
    max-width: 720px;
    margin: 40px auto;
    background: #fff;
    border-radius: 20px;
    padding: 40px 50px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.05);
  }

  h2 {
    text-align: center;
    font-weight: 800;
    color: #2a1f4a;
    margin-bottom: 30px;
  }

  label {
    font-weight: 600;
    color: #433b6c;
    margin-bottom: 6px;
    display: block;
  }

  input, textarea, select {
    border: 1px solid #ddd;
    border-radius: 10px;
    width: 100%;
    padding: 10px 14px;
    font-size: 1rem;
    margin-bottom: 18px;
  }

  input:focus, textarea:focus, select:focus {
    border-color: #a684f2;
    outline: none;
    box-shadow: 0 0 0 3px rgba(166,132,242,0.2);
  }

  .btn-primary {
    background: linear-gradient(90deg, #8B5CF6, #EC4899);
    border: none;
    border-radius: 999px;
    padding: 10px 28px;
    color: white;
    font-weight: 600;
    transition: all 0.2s ease;
  }

  .btn-primary:hover {
    background: linear-gradient(90deg, #7C3AED, #DB2777);
    transform: translateY(-2px);
  }

  .btn-secondary {
    background: #f3f4f6;
    border: none;
    color: #374151;
    border-radius: 999px;
    padding: 10px 22px;
    font-weight: 600;
    transition: all 0.2s ease;
  }

  .btn-secondary:hover {
    background: #e5e7eb;
    transform: translateY(-1px);
  }

  .button-row {
    display: flex;
    gap: 10px;
    justify-content: center;
  }
</style>

<div class="create-container">
  <h2>สร้างโพสต์ใหม่</h2>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
      <label for="title">หัวข้อ</label>
      <input type="text" name="title" id="title" value="{{ old('title') }}" required>
    </div>

    <div class="mb-3">
      <label for="content">รายละเอียด</label>
      <textarea name="content" id="content" rows="6" required>{{ old('content') }}</textarea>
    </div>

    <div class="mb-3">
      <label for="category_id">หมวดหมู่</label>
      <select name="category_id" id="category_id" required>
        <option value="">-- เลือกหมวดหมู่ --</option>
        @foreach ($categories as $cat)
          <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
            {{ $cat->name }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label for="image">อัปโหลดรูป</label>
      <input type="file" name="image" id="image">
    </div>

    <div class="button-row">
      <button type="submit" class="btn-primary">โพสต์</button>
      <a href="{{ url('/') }}" class="btn-secondary">กลับ</a>
    </div>
  </form>
</div>
@endsection
