@extends('layout')

@section('content')

{{-- ✅ ครอบทุกอย่างให้อยู่ในกรอบกลาง --}}
<div class="home-wrap">

  <h2 class="text-center mb-4 fw-bold">หมวดหมู่: {{ $category->name }}</h2>

  <style>
    .home-wrap{
      max-width: 960px;
      margin: 0 auto;
      padding: 0 16px;
    }

    .post-card {
      position: relative;
      background: #fff;
      border: 1px solid #e9ecef;
      border-radius: 16px;
      padding: 16px 18px;
      margin-bottom: 18px;
      box-shadow: 0 4px 10px rgba(0,0,0,.03);
    }

    .post-row {
      display: flex;
      gap: 16px;
      align-items: flex-start;
    }

    .post-thumb {
      width: 120px;
      height: 120px;
      flex: 0 0 120px;
      border-radius: 12px;
      object-fit: cover;
      background: #f3f3f3;
    }

    .post-title {
      font-size: 1.35rem;
      font-weight: 800;
      margin: 0 0 6px;
      color: #1f1b3a;
    }

    .post-meta {
      font-size: .92rem;
      color: #5c6470;
      display: flex;
      gap: 12px;
      flex-wrap: wrap;
    }

    .badge-cat {
      background: #f1ecff;
      color: #5a3cc6;
      border: 1px solid #e3ddff;
      padding: 3px 8px;
      border-radius: 999px;
      font-weight: 600;
    }

    .post-actions {
      position: absolute;
      top: 10px;
      right: 12px;
      display: flex;
      gap: 8px;
    }

    .post-action-btn {
      background: none;
      border: none;
      font-size: 1.2rem;
      cursor: pointer;
      transition: transform .15s ease, opacity .15s ease;
      text-decoration: none;
    }

    .post-action-btn:hover {
      transform: scale(1.15);
      opacity: .85;
    }

    .post-action-btn.delete {
      color: #dc3545;
    }

    .post-content {
      margin-top: 8px;
      color: #2b2f36;
    }
  </style>

  @if ($posts->count())
    @foreach ($posts as $post)
      <div class="post-card">
        {{-- ปุ่มแก้ไข / ลบ สำหรับเจ้าของโพสต์ --}}
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
          {{-- แสดงรูปถ้ามี --}}
          @if($post->image)
            <img src="{{ asset('storage/'.$post->image) }}" class="post-thumb" alt="post image">
          @endif

          <div class="flex-grow-1">
            {{-- หัวข้อโพสต์ --}}
            <h3 class="post-title">
              <a href="{{ route('posts.show', $post->id) }}" class="text-decoration-none text-dark">
                {{ $post->title }}
              </a>
            </h3>

            {{-- ข้อมูลเมตา --}}
            <div class="post-meta">
              <span class="badge-cat">🏷️ {{ $post->category ?? '-' }}</span>
              <span>👤 {{ $post->user->name ?? 'ไม่ระบุผู้ใช้' }}</span>
              <span>🕒 {{ $post->created_at?->diffForHumans() }}</span>
              <span>💬 {{ $post->comments_count ?? $post->comments->count() }} คอมเมนต์</span>
            </div>

            {{-- เนื้อหาย่อ --}}
            <p class="post-content">{{ \Illuminate\Support\Str::limit($post->content, 150) }}</p>
          </div>
        </div>
      </div>
    @endforeach
  @else
    <div class="alert alert-info text-center">ยังไม่มีโพสต์ในหมวดนี้</div>
  @endif

</div> {{-- /.home-wrap --}}

@endsection
