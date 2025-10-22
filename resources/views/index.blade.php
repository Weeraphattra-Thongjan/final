@extends('layout')

@section('content')
<style>
  @import url('https://fonts.googleapis.com/css2?family=Prompt:wght@400;600;700&display=swap');

  .home-wrap{max-width:960px;margin:0 auto;padding:0 16px}

  /* Welcome */
  .welcome-section{text-align:center;margin-top:14px;margin-bottom:18px}
  .welcome-title{
    font-family:'Prompt',sans-serif;font-weight:700;
    font-size:clamp(1.8rem,3.8vw,2.6rem);line-height:1.1;
    background:linear-gradient(90deg,#b57edc,#9370db);
    -webkit-background-clip:text;-webkit-text-fill-color:transparent;
    letter-spacing:.3px;text-shadow:0 2px 0 rgba(147,112,219,.08);margin:0 0 6px
  }
  .welcome-logo{
    width:min(560px,60%);height:auto;display:inline-block;
    animation:float 3.5s ease-in-out infinite;
    filter:drop-shadow(0 8px 12px rgba(0,0,0,.25));
  }
  @keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-10px)}}

  /* Categories */
  #categories{max-width:960px;margin:0 auto 1.2rem}
  .categories-title{font-family:'Prompt',sans-serif;font-weight:700;color:#2f2963;position:relative;display:inline-block;padding-bottom:.25rem}
  .categories-title:after{content:"";position:absolute;left:50%;transform:translateX(-50%);bottom:-6px;width:80px;height:3px;background:#6f58c9;border-radius:999px}
  .category-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(115px,1fr));gap:14px;max-width:900px;margin:0 auto;padding:4px 8px}
  .category-card{background:#fff;border:1px solid #ececf3;border-radius:14px;padding:14px 10px;text-align:center;transition:.18s transform,.18s box-shadow,.18s border-color;user-select:none;height:90px;display:flex;align-items:center;justify-content:center;text-decoration:none}
  .category-card:hover{transform:translateY(-3px);box-shadow:0 6px 16px rgba(0,0,0,.08);border-color:#d8c8f2}
  .cat-just-created{border:2px solid #7B4CFF !important;box-shadow:0 0 0 4px rgba(123,76,255,.15),0 8px 18px rgba(31,27,58,.08) !important}
  .category-label{font-weight:600;color:#263238;letter-spacing:.2px}

  /* Posts */
  .post-card{position:relative;background:#fff;border:1px solid #e9ecef;border-radius:16px;padding:16px 18px;margin-bottom:14px}
  .post-row{display:flex;gap:16px;align-items:flex-start}
  .post-thumb{width:120px;height:120px;flex:0 0 120px;border-radius:12px;object-fit:cover;background:#f3f3f3}
  .post-title{font-size:1.28rem;font-weight:800;margin:0 0 6px;color:#1f1b3a}
  .post-meta{font-size:.92rem;color:#5c6470;display:flex;gap:12px;flex-wrap:wrap}
  .badge-cat{background:#f1ecff;color:#5a3cc6;border:1px solid #e3ddff;padding:3px 8px;border-radius:999px;font-weight:600;text-decoration:none;display:inline-block;transition:.2s all}
  .badge-cat:hover{background:#e8dfff;color:#4b33aa}
  .post-actions{position:absolute;top:10px;right:12px;display:flex;gap:8px}
  .post-action-btn{background:none;border:none;font-size:1.2rem;cursor:pointer;transition:.15s transform,.15s opacity;text-decoration:none}
  .post-action-btn:hover{transform:scale(1.15);opacity:.85}
  .post-action-btn.delete{color:#dc3545}

  /* Button */
  .btn-post{display:inline-block;background:linear-gradient(90deg,#8B5CF6,#EC4899);color:#fff;font-weight:600;padding:10px 22px;border:none;border-radius:999px;box-shadow:0 3px 10px rgba(139,92,246,.4);text-decoration:none;transition:.25s all}
  .btn-post:hover{background:linear-gradient(90deg,#7C3AED,#DB2777);transform:translateY(-2px);box-shadow:0 6px 14px rgba(139,92,246,.5);color:#fff}
</style>

<div class="home-wrap">

  {{-- Welcome --}}
  <div class="welcome-section">
    <h1 class="welcome-title">ยินดีต้อนรับสู่ Wetalk</h1>
    <img src="{{ asset('images/wetalk-logo.png') }}" alt="Wetalk Logo" class="welcome-logo">
  </div>

  {{-- Call-to-action --}}
  @auth
    <a href="{{ route('posts.create') }}" class="btn-post mb-3">สร้างโพสต์ของคุณเลย ✨</a>
  @else
    <a href="{{ route('login') }}" class="btn-post mb-3">เข้าสู่ระบบเพื่อโพสต์</a>
  @endauth

  {{-- Flash messages --}}
  @if(session('success') || session('created_id'))
    <div class="alert alert-success mt-3">
      {{ session('success') }}
      @if(session('created_id'))
        (ID ใหม่: {{ session('created_id') }})
      @endif
    </div>
  @endif

  {{-- Categories --}}
  <section id="categories" class="mt-4">
    <h5 class="categories-title mb-3">หมวดหมู่</h5>

    @if(($categories ?? collect())->isEmpty())
      <div class="text-muted">ยังไม่มีหมวดหมู่</div>
    @else
      <div class="category-grid">
        @foreach($categories as $cat)
          @php $justCreated = session('created_id') == $cat->id; @endphp
          <a href="{{ route('categories.show', $cat->slug) }}"
             class="category-card {{ $justCreated ? 'cat-just-created' : '' }}"
             data-cat-id="{{ $cat->id }}">
            <span class="category-label">{{ $cat->name }}</span>
          </a>
        @endforeach
      </div>
    @endif
  </section>

  {{-- Posts list --}}
  @php
    // mapping ชื่อหมวด -> slug (ลด N+1), ต้องมี $slugMap จากคอนโทรลเลอร์
    $slugMap = $slugMap ?? collect();  // เผื่อไม่ได้ส่งมา
    $catEmoji = [
      'ทั่วไป'=>'🌈','ความรัก'=>'❤️','อาหาร'=>'🍜','ความงาม'=>'💄','ท่องเที่ยว'=>'✈️',
      'บันเทิง'=>'🎬','เทคโนโลยี'=>'💻','สุขภาพ'=>'🧘','การเรียน'=>'📚','กีฬา'=>'⚽',
      'สัตว์เลี้ยง'=>'🐶','งาน / อาชีพ'=>'🧠',
    ];
  @endphp

  @if (($posts ?? collect())->count())
    @foreach ($posts as $post)
      <div class="post-card">
        {{-- owner actions --}}
        @auth
          @if (Auth::id() === ($post->user_id ?? null))
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
          @if(!empty($post->image))
            <img src="{{ asset('storage/'.$post->image) }}" class="post-thumb" alt="post image">
          @endif

          <div class="flex-grow-1">
            <h3 class="post-title">
              <a href="{{ route('posts.show', $post->id) }}" class="text-decoration-none text-dark">
                {{ $post->title }}
              </a>
            </h3>

            <div class="post-meta">
              @php
                $catName = $post->category ?? null;
                $catSlug = $catName ? ($slugMap[$catName] ?? ($slugMap[$catName] ?? null)) : null;
                $emoji   = $catEmoji[$catName] ?? '🏷️';
              @endphp

              <a href="{{ $catSlug ? route('categories.show', $catSlug) : '#' }}" class="badge-cat">
                {{ $emoji }} {{ $catName ?? '-' }}
              </a>

              <span>👤 {{ optional($post->user)->name ?? 'ไม่ระบุผู้ใช้' }}</span>
              <span>🕒 {{ optional($post->created_at)->diffForHumans() }}</span>
              <span>💬 {{ $post->comments_count ?? optional($post->comments)->count() }} คอมเมนต์</span>
            </div>

            <p class="mt-2 mb-0 text-muted">
              {{ \Illuminate\Support\Str::limit($post->content ?? '', 120) }}
            </p>
          </div>
        </div>
      </div>
    @endforeach

    {{-- Pagination (ถ้า $posts เป็น LengthAwarePaginator) --}}
    @if(method_exists($posts, 'links'))
      <div class="mt-3">
        {{ $posts->links() }}
      </div>
    @endif
  @else
    <div class="alert alert-info">ยังไม่มีโพสต์ในระบบ</div>
  @endif

</div> {{-- /.home-wrap --}}
@endsection
