{{-- @extends('layout')

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

  /* ปุ่มสไตล์เดียวกับ “+ สร้างโพสต์” */
  .btn-gradient{
    display:inline-flex; align-items:center; justify-content:center;
    background:linear-gradient(90deg,#7B4CFF,#EC4899);
    color:#fff; font-weight:700; font-size:1rem;
    padding:10px 28px; border:none; border-radius:999px;
    box-shadow:0 4px 12px rgba(139,92,246,.35);
    transition:all .25s ease;
  }
  .btn-gradient:hover{
    background:linear-gradient(90deg,#6A3FE0,#DB2777);
    transform:translateY(-2px);
  }

  .btn-light-soft{
    background:#f3f1ff; border:1px solid #e6e1ff; color:#5b43c9;
    font-weight:700; border-radius:999px; padding:10px 22px;
  }
  .btn-light-soft:hover{background:#e8e2ff;}
  .btn-gradient i{margin-right:6px; font-weight:900;}
</style>


<div class="page-wrap">
  <h2 class="page-title">แก้ไขหมวดหมู่</h2>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

 <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="mt-2">
  @csrf
  @method('PUT')

  <div class="mb-3">
    <label class="form-label">ชื่อหมวดหมู่</label>
    <input
      type="text"
      name="name"
      class="form-control"
      value="{{ old('name', $category->name) }}"
      required
      autofocus
    >
  </div>

  <div class="mb-4">
    <label class="form-label">Slug</label>
    <input
      type="text"
      name="slug"
      class="form-control"
      value="{{ old('slug', $category->slug) }}"
      required
    >
  </div>

  <div class="d-flex gap-3 justify-content-center">
    <button type="submit" class="btn-gradient">บันทึก</button>
  </div>
</form>

</div>
@endsection --}}
