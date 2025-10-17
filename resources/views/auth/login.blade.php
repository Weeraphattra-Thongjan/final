@extends('layout')

@section('content')
<style>
  body {
    background-color: #F5EBFA;
  }

  .auth-container {
    max-width: 480px;
    margin: 60px auto;
    background: #fff;
    border-radius: 20px;
    padding: 35px 40px;
    box-shadow: 0 4px 18px rgba(147, 112, 219, 0.2);
    border: 1px solid #f1e6ff;
  }

  .auth-title {
    text-align: center;
    font-weight: 800;
    font-size: 1.8rem;
    color: #4B0082;
    margin-bottom: 25px;
  }

  .form-control {
    border-radius: 10px;
    padding: 12px;
    border: 1px solid #d8c9f5;
  }

  .btn-gradient {
    background: linear-gradient(90deg, #b57edc, #9370db);
    color: white;
    border: none;
    border-radius: 10px;
    width: 100%;
    padding: 10px 0;
    font-weight: 600;
    transition: 0.3s ease;
    box-shadow: 0 3px 8px rgba(147, 112, 219, 0.3);
  }

  .btn-gradient:hover {
    background: linear-gradient(90deg, #9370db, #b57edc);
    transform: translateY(-2px);
    box-shadow: 0 5px 10px rgba(147, 112, 219, 0.4);
  }

  .auth-footer {
    text-align: center;
    margin-top: 20px;
  }

  .auth-footer a {
    color: #9370db;
    font-weight: 600;
    text-decoration: none;
  }

  .auth-footer a:hover {
    text-decoration: underline;
  }
</style>

<div class="auth-container">
  <h2 class="auth-title">เข้าสู่ระบบ</h2>

  <form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="mb-3">
      <label for="email" class="form-label">อีเมล</label>
      <input id="email" type="email" class="form-control" name="email" required autofocus>
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">รหัสผ่าน</label>
      <input id="password" type="password" class="form-control" name="password" required>
    </div>

    <div class="form-check mb-3">
      <input class="form-check-input" type="checkbox" name="remember" id="remember">
      <label class="form-check-label" for="remember">จดจำฉัน</label>
    </div>

    <button type="submit" class="btn-gradient">เข้าสู่ระบบ</button>
  </form>

  <div class="auth-footer">
    <p>ยังไม่มีบัญชี? <a href="{{ route('register') }}">สมัครสมาชิก</a></p>
  </div>
</div>
@endsection
