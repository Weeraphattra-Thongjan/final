<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wetalk</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@400;500;600&display=swap" rel="stylesheet">

  <style>
    html, body { background-color:#F5EBFA !important; font-family:'Prompt', sans-serif; }
    html { scroll-behavior:smooth; }

    .navbar{ background-color:#9370DB !important; }
    .navbar-dark .navbar-nav .nav-link{ color:#fff !important; }
    .navbar-dark .navbar-nav .nav-link:hover{ color:#F9E366 !important; }

    .btn-outline-success{ border-color:#fff; color:#fff; }
    .btn-outline-success:hover{ background:#fff; color:#9370DB; }

    /* ปุ่ม avatar */
    .nav-profile-toggle{ background:transparent; border:0; padding:0; }
    .nav-profile-toggle img{ width:34px;height:34px;object-fit:cover;border-radius:50%; display:block; }

    .profile-menu .dropdown-item{ padding:.55rem .9rem; }
    .fw-600{ font-weight:600; }

    .btn-primary{
      background:linear-gradient(90deg,#B57EDC,#9370DB);
      border:none; font-weight:600;
      box-shadow:0 3px 6px rgba(0,0,0,.2);
      transition:.3s ease;
    }
    .btn-primary:hover{
      background:linear-gradient(90deg,#9370DB,#B57EDC);
      transform:translateY(-2px);
      box-shadow:0 4px 10px rgba(0,0,0,.3);
    }
    .btn-light{ background:#E6E6FA; color:#4B0082; border:none; }
    .btn-light:hover{ background:#D8BFD8; color:#fff; }
  </style>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container-fluid">
    <a href="{{ url('/') }}" class="navbar-brand fw-600">Wetalk</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-2">
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('index') ? 'active' : '' }}" href="{{ route('index') }}">หน้าแรก</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ url('/#categories') }}">หมวดหมู่</a>
        </li>

        <li class="nav-item d-flex align-items-center">
          <form class="d-flex ms-lg-2" role="search" action="#" method="GET">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">ค้นหา</button>
          </form>
        </li>

        @auth
          {{-- ปุ่ม avatar (ไม่มีชื่อ) --}}
          <li class="nav-item dropdown">
            <button class="nav-profile-toggle" data-bs-toggle="dropdown" aria-expanded="false" title="{{ Auth::user()->name }}">
              <img src="{{ Auth::user()->avatar_url }}" alt="avatar">
            </button>

            <ul class="dropdown-menu dropdown-menu-end shadow-sm profile-menu">
              <li class="px-3 py-2">
                <div class="d-flex align-items-center gap-2">
                  <img src="{{ Auth::user()->avatar_url }}" class="rounded-circle"
                       style="width:42px;height:42px;object-fit:cover">
                  <div>
                    <div class="fw-600">{{ Auth::user()->name }}</div>
                    <div class="small text-muted">{{ Auth::user()->email }}</div>
                  </div>
                </div>
              </li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('profile') }}">
                  <span>👤</span><span>หน้าของฉัน</span>
                </a>
              </li>
              <li>
                <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('profile.edit') }}">
                  <span>⚙️</span><span>จัดการข้อมูลส่วนตัว</span>
                </a>
              </li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <form action="{{ route('logout') }}" method="POST">
                  @csrf
                  <button class="dropdown-item text-danger d-flex align-items-center gap-2">
                    <span>🚪</span><span>ออกจากระบบ</span>
                  </button>
                </form>
              </li>
            </ul>
          </li>
        @else
          <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">ลงชื่อเข้าใช้ / สมัครสมาชิก</a></li>
        @endauth
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-5">
  @yield('content')
</div>

<footer class="p-3 mt-5 text-center" style="background:#9370DB;color:#fff;">
  <p class="mb-0">website for eakapop</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
