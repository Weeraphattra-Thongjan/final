@extends('layout')

@section('content')
  <h2 class="mb-4 text-center fw-bold">จัดการข้อมูลส่วนตัว</h2>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="row g-4">
    {{-- การ์ดข้อมูลโปรไฟล์ --}}
    <div class="col-lg-6">
      <div class="card shadow-sm">
        <div class="card-header fw-600">ข้อมูลโปรไฟล์</div>
        <div class="card-body">
          <div class="text-center mb-3">
            <img src="{{ $user->avatar_url }}" class="rounded-circle"
                 style="width:130px;height:130px;object-fit:cover" alt="Avatar">
          </div>

          <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
              <label class="form-label">ชื่อ</label>
              <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="mb-3">
              <label class="form-label">อีเมล</label>
              <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="mb-3">
              <label class="form-label">เบอร์โทรศัพท์</label>
              <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
              @error('phone') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
              <label class="form-label">รูปโปรไฟล์ใหม่</label>
              <input type="file" name="avatar" class="form-control" accept="image/*">
              <div class="form-text">ไฟล์ภาพ .jpg .jpeg .png .webp สูงสุด 2MB</div>
            </div>

            <button type="submit" class="btn btn-success">บันทึกการเปลี่ยนแปลง</button>
          </form>
        </div>
      </div>
    </div>

    {{-- การ์ดเปลี่ยนรหัสผ่าน --}}
    <div class="col-lg-6">
      <div class="card shadow-sm">
        <div class="card-header fw-600">เปลี่ยนรหัสผ่าน</div>
        <div class="card-body">
          <form action="{{ route('profile.password.update') }}" method="POST">

            @csrf
            @method('PUT')

            <div class="mb-3">
              <label class="form-label">รหัสผ่านปัจจุบัน</label>
              <input type="password" name="current_password" class="form-control" required>
            </div>

            <div class="mb-3">
              <label class="form-label">รหัสผ่านใหม่</label>
              <input type="password" name="password" class="form-control" required minlength="8">
            </div>

            <div class="mb-3">
              <label class="form-label">ยืนยันรหัสผ่านใหม่</label>
              <input type="password" name="password_confirmation" class="form-control" required minlength="8">
            </div>

            <button type="submit" class="btn btn-warning">เปลี่ยนรหัสผ่าน</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
