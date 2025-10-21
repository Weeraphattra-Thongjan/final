@extends('layout')

@section('content')
<div class="container py-4">
  <div class="card" style="border-radius:22px;padding:20px;box-shadow:0 8px 26px rgba(31,27,58,.06)">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h3 class="mb-0 fw-bold">แผงควบคุมผู้ดูแล</h3>
      <div>
        <a href="{{ route('index') }}" class="btn btn-light">← กลับหน้าเว็บบอร์ด</a>
      </div>
    </div>
    @yield('admin')
  </div>
</div>
@endsection
