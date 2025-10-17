@extends('layout')

@section('content')
    <style>
        /* โทนเดียวกับหน้าเพิ่มโพสต์ */
        .page-wrap{
            max-width: 780px; margin: 0 auto;
            background:#fff; border:1px solid #ececf3; border-radius:22px;
            padding:26px 28px; box-shadow:0 8px 26px rgba(31,27,58,.06);
        }
        .page-title{
            font-weight:900; color:#1f1b3a;
            text-align:center; margin-bottom:22px;
        }
        .form-label{font-weight:700; color:#2b2f36}
        .help{color:#8087a2; font-size:.92rem}

    </style>
<h2 class="fw-bold mb-3">เพิ่มหมวดหมู่</h2>

<form action="{{ route('admin.categories.store') }}" method="POST">
  @csrf
  <div class="mb-3">
    <label class="form-label">ชื่อหมวดหมู่</label>
    <input type="text" name="name" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Slug (ตัวอักษรภาษาอังกฤษ เช่น food, travel)</label>
    <input type="text" name="slug" class="form-control" required>
  </div>
  <button class="btn btn-success">บันทึก</button>
  <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">ยกเลิก</a>
</form>
@endsection
