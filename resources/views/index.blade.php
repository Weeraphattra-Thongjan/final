@extends('layout')

@section('content')

<style>
  @import url('https://fonts.googleapis.com/css2?family=Prompt:wght@400;600;700&display=swap');

  .home-wrap{
    max-width: 960px;
    margin: 0 auto;
    padding: 0 16px;
  }

  /* ————— Welcome ————— */
  .welcome-section{
    text-align:center;
    margin-top: 18px;      /* ขยับขึ้น/ลงหัวเรื่องหน้าแรก */
    margin-bottom: 20px;
  }
  .welcome-title{
    font-family:'Prompt',sans-serif;
    font-weight:700;
    font-size: clamp(1.8rem, 3.8vw, 2.6rem);
    line-height:1.1;
    /* ไล่สีเดียวกับ Navbar */
    background: linear-gradient(90deg,#b57edc,#9370db);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    letter-spacing:.4px;
    text-shadow: 0 2px 0 rgba(147,112,219,.08);
    margin: 0 0 6px 0;
  }
  .welcome-logo{
    width: min(420px, 58%);
    max-width: 420px;
    display:block;
    margin: 8px auto 2px;
    filter: drop-shadow(0 6px 18px rgba(147, 112, 219, .15));
  }
  /* ===== โลโก้ Wetalk แบบลอยนุ่ม ๆ พร้อมเงา ===== */
.welcome-logo {
  width: 560px;                /* ขนาดภาพ */
  height: auto;
  display: inline-block;
  animation: float 3.5s ease-in-out infinite; /* เอฟเฟกต์ลอย */
  filter: drop-shadow(0 8px 12px rgba(0, 0, 0, 0.25)); /* เงานุ่มใต้ภาพ */
  transition: transform 0.3s ease;
}

/* กล่องโลโก้ให้อยู่ตรงกลางและขยับขึ้นเล็กน้อย */
.welcome-section {
  text-align: center;
  margin-top: -20px;  /* ขยับโลโก้ขึ้น */
}

/* เอฟเฟกต์ลอยขึ้นลง */
@keyframes float {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-10px); }
}


  /* ————— Post cards ————— */
  .post-card{position:relative;background:#fff;border:1px solid #e9ecef;border-radius:16px;padding:16px 18px;margin-bottom:16px}
  .post-row{display:flex;gap:16px;align-items:flex-start}
  .post-thumb{width:120px;height:120px;flex:0 0 120px;border-radius:12px;object-fit:cover;background:#f3f3f3}
  .post-title{font-size:1.35rem;font-weight:800;margin:0 0 6px;color:#1f1b3a}
  .post-meta{font-size:.92rem;color:#5c6470;display:flex;gap:12px;flex-wrap:wrap}
  .badge-cat{background:#f1ecff;color:#5a3cc6;border:1px solid #e3ddff;padding:3px 8px;border-radius:999px;font-weight:600;text-decoration:none;display:inline-block;transition:all .2s ease}
  .badge-cat:hover{background:#e8dfff;color:#4b33aa}
  .post-actions{position:absolute;top:10px;right:12px;display:flex;gap:8px}
  .post-action-btn{background:none;border:none;font-size:1.2rem;cursor:pointer;transition:transform .15s ease,opacity .15s ease;text-decoration:none}
  .post-action-btn:hover{transform:scale(1.15);opacity:.85}
  .post-action-btn.delete{color:#dc3545}

  /* ปุ่มตั้งกระทู้ */
  .btn-post{
    display:inline-block;background:linear-gradient(90deg,#8B5CF6,#EC4899);
    color:#fff;font-weight:600;padding:10px 22px;border:none;border-radius:999px;
    box-shadow:0 3px 10px rgba(139,92,246,.4);text-decoration:none;transition:all .25s ease;
  }
  .btn-post:hover{background:linear-gradient(90deg,#7C3AED,#DB2777);transform:translateY(-2px);
    box-shadow:0 6px 14px rgba(139,92,246,.5);color:#fff}

  /* กล่องหมวดหมู่ */
  #categories{max-width:960px;margin:0 auto 2rem auto}
  .categories-section,.categories-title,.category-card .label{
    font-family:"Prompt","Noto Sans Thai",system-ui,-apple-system,"Segoe UI",Roboto,Arial,sans-serif;
  }
  .categories-title{
    font-weight:700;color:#2f2963;position:relative;display:inline-block;padding-bottom:.25rem
  }
  .categories-title:after{content:"";position:absolute;left:50%;transform:translateX(-50%);bottom:-6px;width:80px;height:3px;background:#6f58c9;border-radius:999px}
  .category-grid{display:grid;grid-template-columns:repeat(auto-fit, minmax(115px,1fr));gap:16px;max-width:900px;margin:0 auto;padding:4px 8px}
  .category-card{background:#fff;border:1px solid #dee2e6;border-radius:14px;padding:14px 10px;text-align:center;transition:transform .18s ease,box-shadow .18s ease,border-color .18s ease;user-select:none}
  .category-card:hover{transform:translateY(-3px);box-shadow:0 6px 16px rgba(0,0,0,.08);border-color:#d8c8f2}
  .category-link{text-decoration:none;color:inherit;display:block}
  .category-card .icon{font-size:34px;line-height:1;margin-bottom:6px;display:block}
  .category-card .label{font-size:.98rem;font-weight:600;color:#263238;letter-spacing:.2px}
</style>

<div class="home-wrap">
<div class="welcome-section text-center mt-4">
  <h1 class="welcome-title">ยินดีต้อนรับสู่ Wetalk</h1>
  <img src="{{ asset('images/wetalk-logo.png') }}" alt="Wetalk Logo" class="welcome-logo">
</div>


  {{-- ปุ่มตั้งกระทู้ --}}
  @auth
    <a href="{{ route('posts.create') }}" class="btn-post mb-3">สร้างโพสต์ของคุณเลย✨​​</a>
  @else
    <a href="{{ route('login') }}" class="btn-post mb-3">เข้าสู่ระบบเพื่อโพสต์</a>
  @endauth

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  {{-- 🧩 หมวดหมู่ --}}
  <div id="categories" class="mt-5 mb-5 p-4 rounded-4" style="background-color:#f8f9fa;">
    <h3 class="text-center mb-4 categories-title">หมวดหมู่</h3>

    <div class="category-grid categories-section">
      <a href="{{ route('categories.show','general') }}" class="category-link"><div class="category-card"><span class="icon">🌈</span><div class="label">ทั่วไป</div></div></a>
      <a href="{{ route('categories.show','love') }}" class="category-link"><div class="category-card"><span class="icon">❤️</span><div class="label">ความรัก</div></div></a>
      <a href="{{ route('categories.show','food') }}" class="category-link"><div class="category-card"><span class="icon">🍜</span><div class="label">อาหาร</div></div></a>
      <a href="{{ route('categories.show','beauty') }}" class="category-link"><div class="category-card"><span class="icon">👗</span><div class="label">ความงาม</div></div></a>
      <a href="{{ route('categories.show','travel') }}" class="category-link"><div class="category-card"><span class="icon">✈️</span><div class="label">ท่องเที่ยว</div></div></a>
      <a href="{{ route('categories.show','entertainment') }}" class="category-link"><div class="category-card"><span class="icon">🎬</span><div class="label">บันเทิง</div></div></a>
      <a href="{{ route('categories.show','technology') }}" class="category-link"><div class="category-card"><span class="icon">💻</span><div class="label">เทคโนโลยี</div></div></a>
      <a href="{{ route('categories.show','health') }}" class="category-link"><div class="category-card"><span class="icon">🧘</span><div class="label">สุขภาพ</div></div></a>
      <a href="{{ route('categories.show','study') }}" class="category-link"><div class="category-card"><span class="icon">📚</span><div class="label">การเรียน</div></div></a>
      <a href="{{ route('categories.show','sport') }}" class="category-link"><div class="category-card"><span class="icon">⚽</span><div class="label">กีฬา</div></div></a>
      <a href="{{ route('categories.show','pet') }}" class="category-link"><div class="category-card"><span class="icon">🐶</span><div class="label">สัตว์เลี้ยง</div></div></a>
      <a href="{{ route('categories.show','career') }}" class="category-link"><div class="category-card"><span class="icon">🧠</span><div class="label">งาน / อาชีพ</div></div></a>
    </div>
  </div>

  {{-- 📰 ลิสต์โพสต์ --}}
  @php
    // cache slug ของ category ตามชื่อ เพื่อลด query ซ้ำในลูป
    static $catSlugCache = [];
    $slugOf = function($name) use (&$catSlugCache) {
        if (!$name) return null;
        if (!array_key_exists($name, $catSlugCache)) {
            $catSlugCache[$name] = \App\Models\Category::where('name', $name)->value('slug');
        }
        return $catSlugCache[$name];
    };
  @endphp

  @if ($posts->count())
    @foreach ($posts as $post)
      <div class="post-card">
        {{-- ปุ่มเจ้าของโพสต์ (มุมขวาบน) --}}
        @auth
          @if (Auth::id() === $post->user_id)
            <div class="post-actions">
              <a href="{{ route('posts.edit', $post->id) }}" class="post-action-btn" title="แก้ไขโพสต์">✏️</a>
              <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                    onsubmit="return confirm('ต้องการลบโพสต์นี้หรือไม่?');" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="post-action-btn delete" title="ลบโพสต์">🗑️</button>
              </form>
            </div>
          @endif
        @endauth

        <div class="post-row">
          @if($post->image)
            <img src="{{ asset('storage/'.$post->image) }}" class="post-thumb" alt="post image">
          @endif

          <div class="flex-grow-1">
            <h3 class="post-title">
              <a href="{{ route('posts.show', $post->id) }}" class="text-decoration-none text-dark">
                {{ $post->title }}
              </a>
            </h3>

            <div class="post-meta">
              @php $catSlug = $slugOf($post->category); @endphp
              @php
                 $emoji = match($post->category) {
                     'ทั่วไป' => '🌈',
                     'ความรัก' => '❤️',
                     'อาหาร' => '🍜',
                     'ความงาม' => '💄',
                     'ท่องเที่ยว' => '✈️',
                     'บันเทิง' => '🎬',
                     'เทคโนโลยี' => '💻',
                     'สุขภาพ' => '🧘',
                     'การเรียน' => '📚',
                     'กีฬา' => '⚽',
                     'สัตว์เลี้ยง' => '🐶',
                     'งาน / อาชีพ' => '🧠',
                     default => '🏷️',
  };
            @endphp

<a href="{{ $catSlug ? route('categories.show', $catSlug) : '#' }}" class="badge-cat">
  {{ $emoji }} {{ $post->category ?? '-' }}
</a>

              <span>👤 {{ $post->user->name ?? 'ไม่ระบุผู้ใช้' }}</span>
              <span>🕒 {{ $post->created_at?->diffForHumans() }}</span>
              <span>💬 {{ $post->comments_count ?? $post->comments->count() }} คอมเมนต์</span>
            </div>

            <p class="mt-2 mb-0 text-muted">
              {{ \Illuminate\Support\Str::limit($post->content, 120) }}
            </p>
          </div>
        </div>
      </div>
    @endforeach
  @else
    <div class="alert alert-info">ยังไม่มีโพสต์ในระบบ</div>
  @endif

</div> {{-- /.home-wrap --}}

@endsection
