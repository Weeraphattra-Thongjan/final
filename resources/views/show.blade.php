@extends('layout')

@section('content')

<style>
  .topic-container{max-width:920px;margin:0 auto;background:#fff;border:1px solid #ececf3;border-radius:16px;padding:20px 22px}
  .topic-title{font-size:clamp(1.4rem,2.2vw,1.9rem);font-weight:800;color:#1f1b3a;margin-bottom:6px}
  .topic-meta{display:flex;flex-wrap:wrap;gap:12px;color:#657085;font-size:.95rem;margin-bottom:14px}
  .badge-cat{background:#efe9ff;color:#5c3cc6;border:1px solid #e1d8ff;padding:3px 10px;border-radius:999px;font-weight:600;text-decoration:none;display:inline-block;transition:all .15s}
  .badge-cat:hover{background:#e8dfff;color:#4329b2}
  .topic-cover{width:100%;max-height:520px;object-fit:cover;border-radius:12px;display:block;margin:8px 0 12px}
  .topic-content{font-size:1.02rem;line-height:1.7;color:#2b2f36}
  .topic-divider{height:1px;background:#eee;margin:22px 0 16px}
  .cmt-title{font-weight:800;font-size:1.25rem;color:#1f1b3a}

  .cmt-card{background:#fafafe;border:1px solid #eee;border-radius:12px;padding:12px 14px;margin-bottom:12px}
  .cmt-head{display:flex;justify-content:space-between;align-items:center;font-size:.92rem;color:#677084;margin-bottom:6px}
  .cmt-head .left{display:flex;gap:6px;align-items:center}
  .cmt-action-btn{background:none;border:none;font-size:1rem;line-height:1;cursor:pointer;color:#dc3545;transition:transform .15s,opacity .15s}
  .cmt-action-btn:hover{transform:scale(1.1);opacity:.85}

  .post-actions{position:absolute;top:12px;right:16px;display:flex;gap:8px}
  .action-btn{background:none;border:none;font-size:1.4rem;line-height:1;cursor:pointer;transition:transform .2s,opacity .2s}
  .action-btn.delete{color:#dc3545}
  .action-btn:hover{transform:scale(1.2);opacity:.85}

  /* --- ปุ่มไล่สีธีม Wetalk --- */
  .btn-gradient{
    display:inline-block;
    background:linear-gradient(90deg,#8B5CF6,#EC4899);
    color:#fff !important;
    font-weight:700;
    padding:10px 22px;
    border:none;
    border-radius:999px;
    box-shadow:0 4px 12px rgba(139,92,246,.35);
    transition:all .25s ease;
  }
  .btn-gradient:hover{
    background:linear-gradient(90deg,#7C3AED,#DB2777);
    transform:translateY(-2px);
    box-shadow:0 6px 16px rgba(139,92,246,.45);
  }
  .btn-light-soft{
    background:#f3f1ff;border:1px solid #e6e1ff;color:#5b43c9;
  }
</style>

<div class="topic-container position-relative">

  {{-- ปุ่มแก้ไข/ลบโพสต์ (เฉพาะเจ้าของโพสต์) --}}
  @auth
    @if(Auth::id() === $home->user_id)
      <div class="post-actions">
        <a href="{{ route('posts.edit', $home->id) }}" class="action-btn" title="แก้ไขโพสต์">✏️</a>
        <form action="{{ route('posts.destroy', $home->id) }}" method="POST" onsubmit="return confirm('ลบโพสต์นี้หรือไม่?')" class="d-inline">
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
    @php $catSlug = \App\Models\Category::where('name', $home->category)->value('slug'); @endphp
    @if($catSlug)
      <a href="{{ route('categories.show',$catSlug) }}" class="badge-cat">🏷️ {{ $home->category ?? '-' }}</a>
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
  <div class="topic-content">{!! nl2br(e($home->content)) !!}</div>

  <div class="topic-divider"></div>

  {{-- แจ้งเตือน --}}
  @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

  {{-- คอมเมนต์ --}}
  <div class="d-flex align-items-center justify-content-between mb-2">
    <div class="cmt-title">คอมเมนต์</div>
    <div class="text-muted small">
      ทั้งหมด {{ $home->comments_count ?? $home->comments->count() }} ความคิดเห็น
    </div>
  </div>

  @forelse($home->comments as $cmt)
    <div class="cmt-card">
      <div class="cmt-head">
        <div class="left">
          <strong>{{ $cmt->user->name ?? 'ไม่ระบุผู้ใช้' }}</strong>
          <span>•</span>
          <span>{{ $cmt->created_at?->diffForHumans() }}</span>
        </div>

        @auth
          <div>
            {{-- เจ้าของคอมเมนต์ แก้ไข/ลบได้ --}}
            @if(Auth::id() === $cmt->user_id)
              <button type="button" class="cmt-action-btn" title="แก้ไขคอมเมนต์"
                      onclick="toggleEditForm({{ $cmt->id }})">✏️</button>
            @endif

            {{-- เจ้าของคอมเมนต์ หรือ เจ้าของโพสต์ ลบได้ --}}
            @if(Auth::id() === $cmt->user_id || Auth::id() === $home->user_id)
              <form action="{{ route('comment.destroy', ['home' => $home->id, 'comment' => $cmt->id]) }}"
                    method="POST" onsubmit="return confirm('ลบคอมเมนต์นี้ใช่ไหม?')"
                    style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="cmt-action-btn" title="ลบคอมเมนต์">🗑️</button>
              </form>
            @endif
          </div>
        @endauth
      </div>

      {{-- เนื้อหา/รูป --}}
      <div class="cmt-body">{{ $cmt->content }}</div>

      @if(!empty($cmt->image))
        <div class="mt-2">
          <img src="{{ asset('storage/'.$cmt->image) }}" alt="comment image"
               style="max-width:100%;border-radius:8px">
        </div>
      @endif

      {{-- ฟอร์มแก้ไข (ซ่อน) --}}
      @auth
        @if(Auth::id() === $cmt->user_id)
          <div id="edit-cmt-{{ $cmt->id }}" class="mt-2" style="display:none;">
            <form action="{{ route('comment.update', ['home' => $home->id, 'comment' => $cmt->id]) }}"
                  method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <textarea name="content" class="form-control" rows="3" required>{{ old('content', $cmt->content) }}</textarea>
              <div class="mt-2">
                <label class="form-label">รูปใหม่ (ถ้ามี)</label>
                <input type="file" name="image" class="form-control">
              </div>
              <div class="mt-2 d-flex gap-2">
                <button class="btn btn-sm btn-gradient">บันทึก</button>
                <button type="button" class="btn btn-sm btn-light-soft"
                        onclick="toggleEditForm({{ $cmt->id }})">ยกเลิก</button>
              </div>
            </form>
          </div>
        @endif
      @endauth
    </div>
  @empty
    <div class="alert alert-info">ยังไม่มีคอมเมนต์</div>
  @endforelse

  {{-- ฟอร์มเพิ่มคอมเมนต์ --}}
  @auth
    <div class="topic-divider"></div>
    <form action="{{ route('comment.store', $home->id) }}" method="POST" enctype="multipart/form-data" class="cmt-form">
      @csrf
      <div class="mb-2">
        <label class="form-label">คอมเมนต์</label>
        <textarea name="content" class="form-control" rows="3" required>{{ old('content') }}</textarea>
        @error('content') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
      </div>
      <div class="mb-3">
        <label class="form-label">รูปภาพ (ถ้ามี)</label>
        <input type="file" name="image" class="form-control">
        @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
      </div>
      <button type="submit" class="btn-gradient">ส่ง</button>
    </form>
  @else
    <div class="alert alert-light border">เข้าสู่ระบบเพื่อแสดงความคิดเห็น</div>
  @endauth

  <script>
    function toggleEditForm(id){
      const el = document.getElementById('edit-cmt-' + id);
      if (!el) return;
      el.style.display = (el.style.display === 'none' || el.style.display === '') ? 'block' : 'none';
    }
  </script>

@endsection
