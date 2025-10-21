@extends('layout')

@section('content')
<style>
  body { background-color:#F5EBFA; }
  .auth-wrap{
    max-width:520px; margin:60px auto; background:#fff; border-radius:20px;
    padding:34px 40px; border:1px solid #f1e6ff;
    box-shadow:0 6px 22px rgba(147,112,219,.18);
  }
  .auth-title{
    text-align:center; font-weight:800; font-size:1.9rem; color:#4B0082; margin-bottom:22px;
  }
  .form-label{ font-weight:600; color:#3b2e6d; }
  .form-control{
    border-radius:12px; padding:12px 14px; border:1px solid #d9ccf6;
  }
  .form-control:focus{
    border-color:#b58df3; box-shadow:0 0 0 .2rem rgba(147,112,219,.15);
  }
  .btn-gradient{
    display:block; width:100%; border:none; border-radius:12px; padding:12px 16px;
    background:linear-gradient(90deg,#b57edc,#9370db); color:#fff; font-weight:700;
    box-shadow:0 6px 16px rgba(147,112,219,.35); transition:.25s ease;
  }
  .btn-gradient:hover{
    background:linear-gradient(90deg,#9370db,#b57edc); transform:translateY(-2px);
    box-shadow:0 10px 20px rgba(147,112,219,.45);
    color:#fff;
  }
  .auth-footer{ text-align:center; margin-top:16px; }
  .auth-footer a{ color:#7a59d8; font-weight:700; text-decoration:none; }
  .auth-footer a:hover{ text-decoration:underline; }
  .text-danger{ font-size:.9rem; }

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

<div class="auth-wrap">
  <h2 class="auth-title">สมัครสมาชิก</h2>

  <form method="POST" action="{{ route('register') }}">
    @csrf

    {{-- Avatar --}}
    <div class="mb-3">
      <label class="form-label">Avatar (เลือก)</label>
      <div class="d-flex gap-2 flex-wrap">
        @for($i=1; $i<=6; $i++)
          @php $path = 'images/avatars/avatar ('.$i.').png'; @endphp
          <label style="cursor:pointer" class="avatar-select">
            <input type="radio" name="avatar" value="{{ $path }}" class="d-none">
            <img src="{{ asset($path) }}" alt="avatar {{$i}}"
                 style="width:56px;height:56px;object-fit:cover;border-radius:8px;transition:all 0.2s">
          </label>
        @endfor
      </div>
    </div>

    {{-- ชื่อผู้ใช้ --}}
    <div class="mb-3">
      <label for="name" class="form-label">ชื่อ</label>
      <input type="text" name="name" id="name" class="form-control"
             value="{{ old('name') }}" required autocomplete="name" autofocus>
      @error('name') <div class="text-danger mt-1">{{ $message }}</div> @enderror
    </div>

    {{-- เบอร์โทร --}}
    <div class="mb-3">
      <label for="phone" class="form-label">เบอร์โทรศัพท์</label>
      <input type="text" name="phone" id="phone" class="form-control"
             value="{{ old('phone') }}" required>
      @error('phone') <div class="text-danger mt-1">{{ $message }}</div> @enderror
    </div>

    {{-- อีเมล --}}
    <div class="mb-3">
      <label for="email" class="form-label">อีเมล</label>
      <input type="email" name="email" id="email" class="form-control"
             value="{{ old('email') }}" required autocomplete="email">
      @error('email') <div class="text-danger mt-1">{{ $message }}</div> @enderror
    </div>

    {{-- รหัสผ่าน --}}
    <div class="mb-3">
      <label for="password" class="form-label">รหัสผ่าน</label>
      <input type="password" name="password" id="password" class="form-control"
             required autocomplete="new-password">
      @error('password') <div class="text-danger mt-1">{{ $message }}</div> @enderror
    </div>

    {{-- ยืนยันรหัสผ่าน --}}
    <div class="mb-4">
      <label for="password_confirmation" class="form-label">ยืนยันรหัสผ่าน</label>
      <input type="password" name="password_confirmation" id="password_confirmation"
             class="form-control" required autocomplete="new-password">
    </div>

    <button type="submit" class="btn-gradient">สมัครสมาชิก</button>
  </form>

  <div class="auth-footer">
    <p class="mb-0">มีบัญชีอยู่แล้ว?
      <a href="{{ route('login') }}">เข้าสู่ระบบ</a>
    </p>
  </div>
</div>
@endsection
