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
      --ink:#1f1b3a;
      --muted:#667085;
      --ring:#e9e5ff;
      --hover:#f6f4ff;
      --brand:#4c1d95;
    }
    html,body{ background-color:var(--bg)!important; font-family:'Prompt',system-ui,sans-serif; }
    html{ scroll-behavior:smooth; }

    /* ===== NAV (glass) ===== */
    .app-nav{
      position:sticky; top:0; z-index:1000;
      backdrop-filter: blur(10px);
      background: linear-gradient(180deg, rgba(255,255,255,.55), rgba(255,255,255,.35));
      border-bottom: 1px solid rgba(124,58,237,.15);
    }
    .nav-wrap{
      max-width: 1200px; margin: 0 auto; padding: .6rem 1rem;
      display:flex; align-items:center; gap:.75rem;
    }

    /* Brand */
    .brand{
      display:flex; align-items:center; gap:.55rem;
      font-weight:800; color:var(--brand); text-decoration:none; letter-spacing:.2px;
    }
    .brand .dot{
      width:22px;height:22px;border-radius:50%;
      background: var(--nav-grad);
      box-shadow:0 6px 18px rgba(124,58,237,.35);
    }
    .brand-logo{
      width:26px; height:26px; object-fit:contain; display:block;
      filter: drop-shadow(0 2px 6px rgba(0,0,0,.12));
    }

    /* Main links */
    .main-links{ display:flex; gap:.25rem; margin-left:.25rem; }
    .main-link{
      text-decoration:none; color:var(--brand); font-weight:600;
      padding:.45rem .75rem; border-radius:10px;
    }
    .main-link:hover{ background:#efe9ff; }
    .main-link.active{ background:#e9d7ff; }

    /* Search */
    .search{
      display:flex; align-items:center; gap:.4rem; padding:.35rem .6rem;
      border-radius:999px; background:rgba(124,58,237,.12);
      border:1px solid rgba(124,58,237,.18);
    }
    .search input{
      border:0; outline:0; background:transparent; width:160px; color:#4b5563;
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

    /* Avatar button */
    .avatar-btn{ background:transparent; border:0; padding:0; }
    .avatar{
      width:36px;height:36px;border-radius:50%;object-fit:cover; display:block;
      box-shadow:0 4px 12px rgba(0,0,0,.12);
    }
    .status-dot{ position:absolute; right:-2px; bottom:-2px; width:9px;height:9px; border-radius:50%; background:#22c55e; border:2px solid #fff; }
    .fw-600{ font-weight:600; }

    /* Profile dropdown (สวย/เป็นระเบียบ) */
    .profile-menu{
      width:280px; border:1px solid var(--ring); border-radius:16px; overflow:hidden; padding:0;
    }
    .profile-menu .pm-header{
      display:flex; gap:12px; align-items:center;
      padding:12px 14px;
      background:linear-gradient(180deg,#faf8ff,#ffffff);
    }
    .profile-menu .pm-avatar{
      width:46px; height:46px; border-radius:50%; object-fit:cover;
      box-shadow:0 0 0 3px #fff, 0 2px 10px rgba(0,0,0,.12);
    }
    .profile-menu .pm-name{ font-weight:700; color:#2b2760; line-height:1.1; }
    .profile-menu .pm-email{ font-size:.85rem; color:#7b7a8e; }
    .profile-menu .dropdown-item{
      display:flex; align-items:center; gap:.6rem; padding:.7rem 1rem; color:#2b2760;
    }
    .profile-menu .dropdown-item:hover{ background:#f6f4ff; }
    .profile-menu .dropdown-item .pm-ico{
      width:28px; height:28px; border-radius:8px; display:grid; place-items:center;
      background:#f3f0ff; color:#6b53e2; font-size:15px;
    }
    .profile-menu .dropdown-item.pm-danger{ color:#dc3545; }
    .profile-menu .dropdown-item.pm-danger .pm-ico{ background:#ffe8ea; color:#dc3545; }
    .profile-menu .dropdown-divider{ margin:0; }

    /* Page container */
    .page-wrap{ max-width:1100px; margin: 28px auto; padding: 0 16px; }

    /* Responsive */
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

      {{-- โลโก้: ถ้ามีไฟล์ /images/wetalk-logo-icon.png จะแสดงโลโก้แทนจุด --}}
      <a href="{{ url('/') }}" class="brand">
        @php $logo = public_path('images/wetalk-logo-icon.png'); @endphp
        @if(file_exists($logo))
          <img src="{{ asset('images/wetalk-logo.png') }}" alt="Wetalk" class="brand-logo">
          <span>Wetalk</span>
        @else
          <span class="dot"></span> Wetalk
        @endif
      </a>

      <div class="main-links">
        <a href="{{ route('index') }}" class="main-link {{ request()->routeIs('index') ? 'active' : '' }}">หน้าแรก</a>
        <a href="{{ url('/#categories') }}" class="main-link">หมวดหมู่</a>

        {{-- only admin --}}
        @auth
          @if(Auth::user()->role === 'admin')
            <a href="{{ route('admin.categories.index') }}" class="main-link">
              🛠 จัดการหมวดหมู่
            </a>
          @endif
        @endauth


      </div>

      <div class="ms-auto d-flex align-items-center gap-2">


        @auth
          <a href="{{ route('posts.create') }}" class="btn-cta d-none d-md-inline-flex">
            <span>＋</span> สร้างโพสต์
          </a>

          {{-- Profile dropdown --}}
          <div class="dropdown ms-1">
            @php
              $avatar = Auth::user()->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=7C3AED&color=fff';
            @endphp
            <button class="avatar-btn position-relative" data-bs-toggle="dropdown" aria-expanded="false" title="{{ Auth::user()->name }}">
              <img class="avatar" src="{{ $avatar }}" alt="avatar">
              <span class="status-dot"></span>
            </button>

            <ul class="dropdown-menu dropdown-menu-end shadow profile-menu">
              {{-- Header --}}
              <li class="pm-header">
                <img src="{{ $avatar }}" class="pm-avatar" alt="avatar">
                <div>
                  <div class="pm-name">{{ Auth::user()->name }}</div>
                  <div class="pm-email">{{ Auth::user()->email }}</div>
                </div>
              </li>

              <li><hr class="dropdown-divider"></li>

              {{-- Items --}}
              <li>
                <a class="dropdown-item" href="{{ route('profile') }}">
                  <span class="pm-ico">👤</span><span>หน้าของฉัน</span>
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                  <span class="pm-ico">⚙️</span><span>จัดการข้อมูลส่วนตัว</span>
                </a>
              </li>

              <li><hr class="dropdown-divider"></li>

              {{-- Logout --}}
              <li>
                <form action="{{ route('logout') }}" method="POST" class="px-2 pb-2">
                  @csrf
                  <button class="dropdown-item pm-danger">
                    <span class="pm-ico">🧱</span><span>ออกจากระบบ</span>
                  </button>
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
