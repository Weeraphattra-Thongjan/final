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

  {{-- Box: จัดการผู้ใช้ --}}
  <div class="row g-3 mt-3">
    <div class="col-lg-4">
      <div class="p-3 border rounded-4 h-100">
        <div class="h5 mb-3">เพิ่มผู้ใช้ใหม่</div>

        @if(session('user_success'))
          <div class="alert alert-success py-2">{{ session('user_success') }}</div>
        @endif
        @if($userErrors ?? false)
          <div class="alert alert-danger py-2">
            <ul class="mb-0">
              @foreach($userErrors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
          </div>
        @endif

        <form method="post" action="{{ route('admin.users.store') }}" class="vstack gap-2">
          @csrf
          <div>
            <label class="form-label">ชื่อผู้ใช้ (username)</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
          </div>
          <div>
            <label class="form-label">อีเมล</label>
            <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
          </div>
          <div>
            <label class="form-label">เบอร์โทร</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
          </div>
          <button class="btn btn-primary mt-2">+ เพิ่มผู้ใช้</button>
        </form>
      </div>
    </div>

    <div class="col-lg-8">
      <div class="p-3 border rounded-4">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <div class="h5 mb-0">ผู้ใช้ทั้งหมด</div>
          <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm">รีเฟรช</a>
        </div>

        <div class="table-responsive">
          <table class="table align-middle">
            <thead>
              <tr>
                <th style="width:60px">#</th>
                <th style="width:80px">Avatar</th>
                <th>Username</th>
                <th>อีเมล / เบอร์โทร</th>
                <th class="text-end" style="width:240px">จัดการ</th>
              </tr>
            </thead>
            <tbody>
              @forelse($users as $user)
                <tr id="user-row-{{ $user->id }}">
                  <td>{{ $user->id }}</td>
                 <td class="user-view">
                   @if($user->avatar)
                     <img src="{{ asset($user->avatar) }}" 
                          alt="avatar" 
                          class="rounded-circle"
                          style="width:40px;height:40px;object-fit:cover">
                   @else
                     <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center text-white"
                          style="width:40px;height:40px">
                       {{ strtoupper(substr($user->name, 0, 1)) }}
                     </div>
                   @endif
                 </td>

                  {{-- โหมดดู --}}
                  <td class="user-view name-{{ $user->id }}">{{ $user->name }}</td>
                  <td class="user-view contact-{{ $user->id }}">{{ $user->email }}<br>{{ $user->phone }}</td>

                  {{-- โหมดแก้ไข (ซ่อนเริ่มต้น) --}}
                  <td colspan="2" class="user-edit d-none" id="user-edit-{{ $user->id }}">
                    <form method="post" action="{{ route('admin.users.update', $user) }}" class="row g-2 align-items-center">
                      @csrf @method('PUT')
                      <div class="col-md-3">
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                      </div>
                      <div class="col-md-4">
                        <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                      </div>
                      <div class="col-md-3">
                        <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
                      </div>

                      <div class="w-100"></div>
                      <div class="col-12">
                        <div class="small text-muted mb-1">Avatar</div>
                        <div class="d-flex gap-2 flex-wrap">
                          @for($i=1; $i<=6; $i++)
                            @php $path = 'images/avatars/avatar ('.$i.').png'; @endphp
                            <label style="cursor:pointer" class="avatar-select">
                              <input type="radio" name="avatar" value="{{ $path }}" class="d-none" {{ $user->avatar === $path ? 'checked' : '' }}>
                              <img src="{{ asset($path) }}" alt="avatar {{$i}}"
                                   style="width:40px;height:40px;object-fit:cover;border-radius:6px;transition:all 0.2s">
                            </label>
                          @endfor
                        </div>
                      </div>
                      <div class="col-md-2 d-flex gap-2">
                        <button class="btn btn-primary w-100">✓</button>
                        <button type="button" class="btn btn-light w-100" onclick="toggleUserEdit({{ $user->id }}, false)">✗</button>
                      </div>
                    </form>
                  </td>

                  <td class="text-end user-view">
                    <button class="btn btn-sm btn-warning" onclick="toggleUserEdit({{ $user->id }}, true)">แก้ไข</button>

                    <form action="{{ route('admin.users.destroy', $user) }}"
                          method="post" class="d-inline"
                          onsubmit="return confirm('ยืนยันลบผู้ใช้?')">
                      @csrf @method('DELETE')
                      <button class="btn btn-sm btn-danger">ลบ</button>
                    </form>
                  </td>
                </tr>
              @empty
                <tr><td colspan="4" class="text-center text-muted">ยังไม่มีผู้ใช้</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div>
          {{ $users->links() }}
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

  <script>
    // ฟังก์ชันเดิมสำหรับหมวดหมู่
    function toggleEdit(id, on){
      const row = document.getElementById('row-'+id);
      const edit = document.getElementById('edit-'+id);
      if(!row || !edit) return;

      row.querySelectorAll('.view').forEach(el => el.classList.toggle('d-none', !!on));
      edit.classList.toggle('d-none', !on);
    }

    // ฟังก์ชันใหม่สำหรับผู้ใช้ (แยก id prefix)
    function toggleUserEdit(id, on){
      const row = document.getElementById('user-row-'+id);
      const edit = document.getElementById('user-edit-'+id);
      if(!row || !edit) return;

      row.querySelectorAll('.user-view').forEach(el => el.classList.toggle('d-none', !!on));
      edit.classList.toggle('d-none', !on);
    }
  </script>

  <style>
    .avatar-select img {
      opacity: 0.6;
      border: 2px solid transparent;
    }
    .avatar-select input:checked + img {
      opacity: 1;
      border-color: #0d6efd;
      transform: scale(1.05);
    }
  </style>
  
@endsection
