@extends('layout')

@section('content')

<style>
  .topic-container{
    max-width: 920px;
    margin: 0 auto;
    background:#fff;
    border:1px solid #ececf3;
    border-radius:16px;
    padding:20px 22px;
  }
  .topic-title{font-size:clamp(1.4rem,2.2vw,1.9rem);font-weight:800;color:#1f1b3a;margin-bottom:6px}
  .topic-meta{display:flex;flex-wrap:wrap;gap:12px;color:#657085;font-size:.95rem;margin-bottom:14px}
  .badge-cat{
    background:#efe9ff;color:#5c3cc6;border:1px solid #e1d8ff;
    padding:3px 10px;border-radius:999px;font-weight:600;
    text-decoration:none; display:inline-block; transition:all .15s ease;
  }
  .badge-cat:hover{ background:#e8dfff; color:#4329b2; }
  .topic-cover{width:100%;max-height:520px;object-fit:cover;border-radius:12px;display:block;margin:8px 0 12px}
  .topic-content{font-size:1.02rem;line-height:1.7;color:#2b2f36}
  .topic-divider{height:1px;background:#eee;margin:22px 0 16px}
  .cmt-title{font-weight:800;font-size:1.25rem;color:#1f1b3a}

  /* comment card */
  .cmt-card{background:#fafafe;border:1px solid #eee;border-radius:12px;padding:12px 14px;margin-bottom:12px}
  .cmt-head{display:flex;justify-content:space-between;align-items:center;font-size:.92rem;color:#677084;margin-bottom:6px}
  .cmt-head .left{display:flex;gap:6px;align-items:center}
  .cmt-action-btn{background:none;border:none;font-size:1rem;line-height:1;cursor:pointer;color:#dc3545;transition:transform .15s ease,opacity .15s ease}
  .cmt-action-btn:hover{transform:scale(1.15);opacity:.8}
  .cmt-body{white-space:pre-line;color:#2b2f36}

  /* post header actions (edit/delete) */
  .post-actions{
    position:absolute; top:12px; right:16px; display:flex; gap:8px; align-items:center;
  }
  .action-btn{background:none;border:none;font-size:1.4rem;line-height:1;cursor:pointer;transition:transform .2s ease,opacity .2s ease}
  .action-btn.edit:hover,.action-btn.delete:hover{transform:scale(1.2);opacity:.8}
  .action-btn.delete{color:#dc3545}
</style>

<div class="topic-container position-relative">

  {{-- ปุ่มแก้ไข / ลบ (เฉพาะเจ้าของโพสต์เท่านั้น) --}}
  @auth
    @if(Auth::id() === $home->user_id)
      <div class="post-actions">
        <a href="{{ route('posts.edit', $home->id) }}" class="action-btn edit" title="แก้ไขโพสต์">✏️</a>
        <form action="{{ route('posts.destroy', $home->id) }}" method="POST"
              onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบโพสต์นี้?')" class="d-inline">
          @csrf
          @method('DELETE')
          <button type="submit" class="action-btn delete" title="ลบโพสต์">🗑️</button>
        </form>
      </div>
    @endif
  @endauth

  {{-- หัวข้อ --}}
  <h1 class="topic-title">{{ $home->title }}</h1>

  {{-- เมตา --}}
  <div class="topic-meta">
    @php
      $catSlug = \App\Models\Category::where('name', $home->category)->value('slug');
    @endphp
    @if($catSlug)
      <a href="{{ route('categories.show', $catSlug) }}" class="badge-cat">🏷️ {{ $home->category ?? '-' }}</a>
    @else
      <span class="badge-cat">🏷️ {{ $home->category ?? '-' }}</span>
    @endif

    <span>👤 {{ $home->user->name ?? 'ไม่ระบุผู้ใช้' }}</span>
    <span>🕒 {{ $home->created_at?->format('d M Y H:i') }}</span>
    <span>💬 {{ $home->comments_count ?? $home->comments->count() }} คอมเมนต์</span>
  </div>

  {{-- รูปปก --}}
  @if(!empty($home->image))
    <img src="{{ asset('storage/'.$home->image) }}" alt="cover" class="topic-cover">
  @endif

  {{-- เนื้อหา --}}
  <div class="topic-content">
    {!! nl2br(e($home->content)) !!}
  </div>

  <div class="topic-divider"></div>

  {{-- คอมเมนต์ --}}
  <div class="d-flex align-items-center justify-content-between mb-2">
    <div class="cmt-title">คอมเมนต์</div>
    <div class="text-muted small">ทั้งหมด {{ $home->comments_count ?? $home->comments->count() }} ความคิดเห็น</div>
  </div>

  @forelse($home->comments as $cmt)
    <div class="cmt-card">
      <div class="cmt-head">
        <div class="left">
          <strong>{{ $cmt->user->name ?? 'ไม่ระบุผู้ใช้' }}</strong>
          <span>•</span>
          <span>{{ $cmt->created_at?->diffForHumans() }}</span>
        </div>

        {{-- ปุ่มลบเฉพาะเจ้าของคอมเมนต์ --}}
        @auth
          @if(Auth::id() === $cmt->user_id)
            <form action="{{ route('comment.destroy', [$home->id, $cmt->id]) }}"
                  method="POST"
                  onsubmit="return confirm('ลบคอมเมนต์นี้ใช่ไหม?')"
                  style="margin:0;">
              @csrf
              @method('DELETE')
              <button type="submit" class="cmt-action-btn" title="ลบคอมเมนต์">🗑️</button>
            </form>
          @endif
        @endauth
      </div>

      <div class="cmt-body">{{ $cmt->content }}</div>

      @if(!empty($cmt->image))
        <div class="mt-2">
          <img src="{{ asset('storage/'.$cmt->image) }}" alt="comment image" style="max-width:100%;border-radius:8px">
        </div>
      @endif
    </div>
  @empty
    <div class="alert alert-info">ยังไม่มีคอมเมนต์</div>
  @endforelse

  {{-- ฟอร์มคอมเมนต์ --}}
  @auth
    <div class="topic-divider"></div>
    <form action="{{ route('comment.store', $home->id) }}" method="POST" enctype="multipart/form-data" class="cmt-form">
      @csrf
      <div class="mb-2">
        <label class="form-label">คอมเมนต์</label>
        <textarea name="content" class="form-control" required></textarea>
      </div>
      <div class="mb-3">
        <label class="form-label">รูปภาพ (ถ้ามี)</label>
        <input type="file" name="image" class="form-control">
      </div>
      <button class="btn btn-primary">ส่งคอมเมนต์</button>
    </form>
  @else
    <div class="alert alert-light border">เข้าสู่ระบบเพื่อแสดงความคิดเห็น</div>
  @endauth

</div>
@endsection
