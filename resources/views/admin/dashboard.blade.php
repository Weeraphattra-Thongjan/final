@extends('admin.layout')

@section('admin')

  {{-- กล่องจัดการหมวดหมู่ --}}
  <div class="row g-3">
    <div class="col-lg-4">
      <div class="p-3 border rounded-4 h-100">
        <div class="h5 mb-3">เพิ่มหมวดหมู่ใหม่</div>

        @if(session('success'))
          <div class="alert alert-success py-2">{{ session('success') }}</div>
        @endif
        @if($errors->any())
          <div class="alert alert-danger py-2">
            <ul class="mb-0">
              @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
          </div>
        @endif

        <form method="post" action="{{ route('admin.categories.store') }}" class="vstack gap-2">
          @csrf
          <div>
            <label class="form-label">ชื่อหมวดหมู่</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
          </div>
          <div>
            <label class="form-label">Slug</label>
            <input type="text" name="slug" class="form-control" value="{{ old('slug') }}">
          </div>
          <button class="btn btn-primary mt-2">+ เพิ่มหมวดหมู่</button>
        </form>
      </div>
    </div>

    <div class="col-lg-8">
      <div class="p-3 border rounded-4">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <div class="h5 mb-0">หมวดหมู่ทั้งหมด</div>
          {{-- ปุ่มรีเฟรชหน้านี้ --}}
          <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm">รีเฟรช</a>
        </div>

        <div class="table-responsive">
          <table class="table align-middle">
            <thead>
              <tr>
                <th style="width:60px">#</th>
                <th>ชื่อ</th>
                <th>Slug</th>
                <th class="text-end" style="width:220px">จัดการ</th>
              </tr>
            </thead>
            <tbody>
              @forelse($categories as $cat)
                <tr id="row-{{ $cat->id }}">
                  <td>{{ $cat->id }}</td>

                  {{-- โหมดดู --}}
                  <td class="view name-{{ $cat->id }}">{{ $cat->name }}</td>
                  <td class="view slug-{{ $cat->id }}">{{ $cat->slug }}</td>

                  {{-- โหมดแก้ไข (ซ่อนเริ่มต้น) --}}
                  <td colspan="2" class="edit d-none" id="edit-{{ $cat->id }}">
                    <form method="post" action="{{ route('admin.categories.update',$cat) }}" class="row g-2">
                      @csrf @method('PUT')
                      <div class="col-md-4">
                        <input type="text" name="name" class="form-control" value="{{ $cat->name }}" required>
                      </div>
                      <div class="col-md-4">
                        <input type="text" name="slug" class="form-control" value="{{ $cat->slug }}">
                      </div>
                      <div class="col-md-4 d-flex gap-2">
                        <button class="btn btn-primary">บันทึก</button>
                        <button type="button" class="btn btn-light" onclick="toggleEdit({{ $cat->id }}, false)">ยกเลิก</button>
                      </div>
                    </form>
                  </td>

                  <td class="text-end view">
                    <button class="btn btn-sm btn-warning" onclick="toggleEdit({{ $cat->id }}, true)">แก้ไข</button>

                    <form action="{{ route('admin.categories.destroy',$cat) }}"
                          method="post" class="d-inline"
                          onsubmit="return confirm('ยืนยันลบหมวดหมู่?')">
                      @csrf @method('DELETE')
                      <button class="btn btn-sm btn-danger">ลบ</button>
                    </form>
                  </td>
                </tr>
              @empty
                <tr><td colspan="4" class="text-center text-muted">ยังไม่มีหมวดหมู่</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div>
          {{ $categories->links() }}
        </div>
      </div>
    </div>
  </div>

  <script>
    function toggleEdit(id, on){
      const row = document.getElementById('row-'+id);
      const edit = document.getElementById('edit-'+id);
      if(!row || !edit) return;

      row.querySelectorAll('.view').forEach(el => el.classList.toggle('d-none', !!on));
      edit.classList.toggle('d-none', !on);
    }
  </script>
  
@endsection
