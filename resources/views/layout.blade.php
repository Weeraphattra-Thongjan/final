<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wetalk</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root{
      --bg:#F5EBFA;
      --nav-grad: linear-gradient(135deg,#7C3AED 0%, #EC4899 100%);
      --chip:#f1ecff;
      --ink:#1f1b3a;
      --muted:#667085;
    }
    html,body{ background-color:var(--bg)!important; font-family:'Prompt',system-ui,sans-serif; }
    html{ scroll-behavior:smooth; }

    /* ===== NAV (custom glass) ===== */
    .app-nav{
      position:sticky; top:0; z-index:1000;
      backdrop-filter: blur(10px);
      background: linear-gradient(180deg, rgba(255,255,255,.55), rgba(255,255,255,.35));
      border-bottom: 1px solid rgba(124,58,237,.15);
    }
    .nav-wrap{
      max-width: 1200px;
      margin: 0 auto;
      padding: .6rem 1rem;
      display:flex; align-items:center; gap:.75rem;
    }
    .brand{
      display:flex; align-items:center; gap:.55rem;
      font-weight:800; color:#4c1d95; text-decoration:none;
      letter-spacing:.2px;
    }
    .brand .dot{
      width:22px;height:22px;border-radius:50%;
      background: var(--nav-grad);
      box-shadow:0 6px 18px rgba(124,58,237,.35);
    }

    .main-links{ display:flex; gap:.25rem; margin-left:.25rem; }
    .main-link{
      text-decoration:none; color:#4c1d95; font-weight:600;
      padding:.45rem .75rem; border-radius:10px;
    }
    .main-link:hover{ background:#efe9ff; }
    .main-link.active{ background:#e9d7ff; }

    /* search */
    .search{
      display:flex; align-items:center; gap:.4rem; padding:.35rem .6rem;
      border-radius:999px; background:rgba(124,58,237,.12);
      border:1px solid rgba(124,58,237,.18);
    }
    .search input{
      border:0; outline:0; background:transparent; width:160px;
      color:#4b5563;
    }
    .search input::placeholder{ color:#9ca3af; }

    /* CTA */
    .btn-cta{
      border:0; border-radius:999px; padding:.5rem .9rem;
      color:#fff; background:var(--nav-grad);
      box-shadow:0 8px 20px rgba(124,58,237,.3);
      text-decoration:none; font-weight:700; gap:.4rem; display:inline-flex; align-items:center;
      transition:.2s ease;
    }
    .btn-cta:hover{ transform:translateY(-1px); color:#fff; box-shadow:0 10px 24px rgba(124,58,237,.35); }

    /* avatar */
    .avatar-btn{ background:transparent; border:0; padding:0; }
    .avatar{ width:36px;height:36px;border-radius:50%;object-fit:cover; display:block;
      box-shadow:0 4px 12px rgba(0,0,0,.12);
    }
    .status-dot{ position:absolute; right:-2px; bottom:-2px; width:9px;height:9px; border-radius:50%; background:#22c55e; border:2px solid #fff; }
    .fw-600{ font-weight:600; }

    /* page container & footer */
    .page-wrap{ max-width:1100px; margin: 28px auto; padding: 0 16px; }
    footer{ background:#7C3AED; color:#fff; }
    .welcome-logo {
     width: 480px;
  height: auto;
  display: inline-block;
  animation: float 3s ease-in-out infinite; /* เพิ่มความน่ารักแบบเด้งเบาๆ */
}
    .welcome-section {
  margin-top: -30px; /* ทั้งกล่องจะขยับขึ้น */
}

/* ทำให้โลโก้ลอยขึ้นลงนิด ๆ */
    @keyframes float {
  0%, 100% { transform: translateY(0px); }
  50% { transform: translateY(-6px); }
}


    /* small */
    @media (max-width: 992px){
      .main-links{ display:none; }
      .search input{ width:110px; }
      .d-md-inline-flex{ display:none!important; }
    }
  </style>
</head>

<body>

  {{-- NAVBAR --}}
  <nav class="app-nav">
    <div class="nav-wrap">

      <a href="{{ url('/') }}" class="brand">
        <span class="dot"></span> Wetalk
      </a>

      <div class="main-links">
        <a href="{{ route('index') }}" class="main-link {{ request()->routeIs('index') ? 'active' : '' }}">หน้าแรก</a>
        <a href="{{ url('/#categories') }}" class="main-link">หมวดหมู่</a>
      </div>

      <div class="ms-auto d-flex align-items-center gap-2">

        <form action="#" method="GET" class="search" role="search">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
            <path d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z"
                  stroke="#6b21a8" stroke-width="2" stroke-linecap="round"/>
          </svg>
          <input type="search" name="q" placeholder="ค้นหา…">
        </form>

        @auth
          <a href="{{ route('posts.create') }}" class="btn-cta d-none d-md-inline-flex">
            <span>＋</span> สร้างโพสต์
          </a>

          <div class="dropdown ms-1">
            @php
              $avatar = Auth::user()->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=7C3AED&color=fff';
            @endphp
            <button class="avatar-btn position-relative" data-bs-toggle="dropdown" aria-expanded="false" title="{{ Auth::user()->name }}">
              <img class="avatar" src="{{ $avatar }}" alt="avatar">
              <span class="status-dot"></span>
            </button>

            <ul class="dropdown-menu dropdown-menu-end shadow-sm profile-menu">
              <li class="px-3 py-2">
                <div class="d-flex align-items-center gap-2">
                  <img src="{{ $avatar }}" class="rounded-circle" style="width:42px;height:42px;object-fit:cover">
                  <div>
                    <div class="fw-600">{{ Auth::user()->name }}</div>
                    <div class="small text-muted">{{ Auth::user()->email }}</div>
                  </div>
                </div>
              </li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="{{ route('profile') }}">หน้าของฉัน</a></li>
              <li><a class="dropdown-item" href="{{ route('profile.edit') }}">จัดการข้อมูลส่วนตัว</a></li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <form action="{{ route('logout') }}" method="POST" class="px-3 pb-2">
                  @csrf
                  <button class="dropdown-item text-danger">ออกจากระบบ</button>
                </form>
              </li>
            </ul>
          </div>
        @else
          <a href="{{ route('login') }}" class="main-link" style="background:#fff;color:#6b21a8;">เข้าสู่ระบบ</a>
        @endauth

      </div>
    </div>
  </nav>

  {{-- PAGE CONTENT --}}
  <div class="page-wrap">
    @yield('content')
  </div>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
