@extends('layout')

@section('content')
  <h2 class="mb-4 text-center fw-bold">เปลี่ยนรหัสผ่าน</h2>

  <form action="{{ route('profile.password.update') }}" method="POST" class="mx-auto" style="max-width:520px;">
    @csrf
    @method('PUT')

    <div class="mb-3">
      <label class="form-label">รหัสผ่านเดิม</label>
      <input type="password" name="current_password" class="form-control" required>
      @error('current_password')<div class="text-danger small">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
      <label class="form-label">รหัสผ่านใหม่</label>
      <input type="password" name="password" class="form-control" required>
      @error('password')<div class="text-danger small">{{ $message }}</div>@enderror
    </div>

    <div class="mb-4">
      <label class="form-label">ยืนยันรหัสผ่านใหม่</label>
      <input type="password" name="password_confirmation" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">บันทึก</button>
  </form>
@endsection
