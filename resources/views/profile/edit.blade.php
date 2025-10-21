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
                <div class="text-center mb-4">
                    @if(Auth::user()->avatar)
                        <img src="{{ asset(Auth::user()->avatar) }}" 
                             class="rounded-circle mb-2" 
                             style="width:120px;height:120px;object-fit:cover"
                             alt="Profile Avatar">
                    @else
                        <div class="rounded-circle bg-secondary text-white mx-auto mb-2 d-flex align-items-center justify-content-center"
                             style="width:120px;height:120px;font-size:48px">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    @endif
                </div>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Avatar Selection -->
                    <div class="mb-3">
                        <label class="form-label">เลือก Avatar</label>
                        <div class="d-flex gap-2 flex-wrap mb-2">
                            @for($i=1; $i<=6; $i++)
                                @php $path = 'images/avatars/avatar ('.$i.').png'; @endphp
                                <label class="avatar-select">
                                    <input type="radio" name="avatar" value="{{ $path }}" 
                                           {{ Auth::user()->avatar === $path ? 'checked' : '' }}
                                           class="d-none">
                                    <img src="{{ asset($path) }}" 
                                         alt="Avatar option {{ $i }}"
                                         style="width:64px;height:64px;object-fit:cover;border-radius:8px;">
                                </label>
                            @endfor
                        </div>
                        
                        <div class="mt-3">
                            <label class="form-label">หรืออัพโหลดรูปของคุณ</label>
                            <input type="file" name="avatar_upload" class="form-control" accept="image/*">
                            <div class="form-text">รองรับไฟล์ .jpg .png .webp ขนาดไม่เกิน 2MB</div>
                        </div>
                    </div>

                    <!-- Other form fields -->
                    <div class="mb-3">
                        <label class="form-label">ชื่อ</label>
                        <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">อีเมล</label>
                        <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">เบอร์โทรศัพท์</label>
                        <input type="text" name="phone" class="form-control" value="{{ Auth::user()->phone }}">
                    </div>

                    <button type="submit" class="btn btn-primary w-100">บันทึกการเปลี่ยนแปลง</button>
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

  <style>
  .avatar-select img {
      opacity: 0.6;
      border: 2px solid transparent;
      transition: all 0.2s;
  }
  .avatar-select input:checked + img {
      opacity: 1;
      border-color: #0d6efd;
      transform: scale(1.05);
  }
  </style>
@endsection
