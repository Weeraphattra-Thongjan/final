{{-- @extends('layout')

@section('content')
<style>
  .wrap{max-width:1000px;margin:0 auto}
  .card{
    background:#fff;border:1px solid #ececf3;border-radius:22px;
    padding:20px 22px;box-shadow:0 8px 26px rgba(31,27,58,.06)
  }
  .title{font-weight:900;color:#1f1b3a}
  .toolbar{display:flex;gap:10px;flex-wrap:wrap;align-items:center}

  /* ปุ่มไล่สีแบบ “+ สร้างโพสต์” */
  .btn-gradient{
    display:inline-flex;
    align-items:center;
    gap:6px;
    background:linear-gradient(90deg,#7B4CFF,#EC4899);
    color:#fff !important;
    font-weight:700;
    border:none;
    border-radius:999px;
    padding:10px 18px;
    box-shadow:0 4px 12px rgba(139,92,246,.35);
    transition:.25s all
    text-decoration: none;

  }
  .btn-gradient:hover{
    background:linear-gradient(90deg,#6A3FE0,#DB2777);
    transform:translateY(-2px)}
    text-decoration: none;
  .search{flex:1 1 260px}
  .search .form-control{border-radius:12px}

  /* ตารางสวย ๆ */
  .tbl{width:100%;border-collapse:separate;border-spacing:0;overflow:hidden;border-radius:16px;border:1px solid #ececf3}
  .tbl thead th{
    background:#faf7ff;color:#2f2963;font-weight:800;border-bottom:1px solid #ececf3
  }
  .tbl th,.tbl td{padding:12px 14px;vertical-align:middle}
  .tbl tbody tr:nth-child(odd){background:#fff}
  .tbl tbody tr:nth-child(even){background:#fcfbff}
  .tbl tbody tr:hover{background:#f5f2ff}
  .col-id{width:70px;text-align:center}
  .col-actions{width:160px;text-align:right}
  .slug{font-family:ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace}

  .btn-xs{padding:6px 10px;border-radius:10px;font-weight:700}
  .btn-edit{background:#ffd166;border:1px solid #ffc145;color:#573c00}
  .btn-edit:hover{background:#ffc949}
  .btn-del{background:#ffe5e9;border:1px solid #ffc2cb;color:#d22}
  .btn-del:hover{background:#ffd9df}
  @media (max-width: 640px){
    .col-slug{display:none} /* ย่อ slug ออกบนจอเล็ก */
    .col-actions{width:auto}
  }
</style>

<div class="wrap">
  <div class="mb-3 d-flex justify-content-between align-items-center">
    <h2 class="title mb-0">จัดการหมวดหมู่</h2>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if($errors->any())
    <div class="alert alert-danger mb-3">
      <ul class="mb-0">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
      </ul>
    </div>
  @endif

  <div class="card">
    <div class="toolbar mb-3">
        <a href="{{ route('admin.categories.create') }}" class="btn-gradient" style="text-decoration:none;">＋ เพิ่มหมวดหมู่</a>
    </div>

    <div class="table-responsive">
      <table class="tbl">
        <thead>
          <tr>
            <th class="col-id">#</th>
            <th>ชื่อหมวดหมู่</th>
            <th class="col-slug">  </th>
            <th class="col-actions">จัดการ</th>
          </tr>
        </thead>
        <tbody>
          @forelse($categories as $cat)
            <tr>
              <td class="col-id">{{ $loop->iteration }}</td>
              <td>{{ $cat->name }}</td>
              <td class="col-slug"><span class="slug">{{ $cat->slug }}</span></td>
              <td class="col-actions">
                <a href="{{ route('admin.categories.edit', $cat->id) }}" class="btn btn-edit btn-xs">แก้ไข</a>
                <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" style="display:inline"
                      onsubmit="return confirm('ลบหมวดหมู่ “{{ $cat->name }}” ?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn btn-del btn-xs">ลบ</button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="4" class="text-center text-muted py-4">ยังไม่มีหมวดหมู่</td></tr>
          @endforelse
        </tbody>
      </table>
    </div> --}}

    {{-- ถ้ามี paginate ส่งมาด้วย --}}
    {{-- @if(method_exists($categories,'links'))
      <div class="mt-3">
        {{ $categories->withQueryString()->links() }}
      </div>
    @endif
  </div>
</div>
@endsection --}}
