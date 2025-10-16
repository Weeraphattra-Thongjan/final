@extends('layout')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold text-center" style="color:#4B0082;">แก้ไขคอมเมนต์</h2>

    @if (session('success'))
        <div class="alert alert-success text-center rounded-3">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>พบข้อผิดพลาด:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    {{-- ฟอร์มแก้ไขคอมเมนต์ (ตามที่ขอ: method="POST" + @method('PUT')) --}}
    <form action="{{ route('home.update', $home->id) }}" method="POST" class="bg-white p-4 rounded-4 shadow-sm" style="max-width:720px;margin:0 auto;">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="comment" class="form-label fw-semibold">ข้อความคอมเมนต์</label>
            <textarea name="comment" id="comment" rows="5" class="form-control" required>{{ old('comment', $home->comment ?? '') }}</textarea>
        </div>

        @if(!empty($categories))
            <div class="mb-3">
                <label for="category_id" class="form-label fw-semibold">หมวดหมู่ (ถ้ามี)</label>
                <select name="category_id" id="category_id" class="form-select">
                    <option value="">-- เลือกหมวดหมู่ --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ (isset($home->category_id) && $home->category_id == $category->id) ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif

        <div class="d-flex justify-content-center gap-2">
            <button type="submit" class="btn btn-primary px-4">💾 บันทึกการแก้ไข</button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary px-4">ยกเลิก</a>
        </div>
    </form>

    {{-- ปุ่มลบคอมเมนต์ (ถ้าอยากลบจากหน้านี้เลย) --}}
    <div class="text-center mt-3">
        <form action="{{ route('home.destroy', $home->id) }}" method="POST" onsubmit="return confirm('แน่ใจหรือไม่ว่าต้องการลบคอมเมนต์นี้?');" style="display:inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger px-4">ลบคอมเมนต์</button>
        </form>
    </div>
</div>
@endsection
