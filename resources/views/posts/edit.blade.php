@extends('layout')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold text-center" style="color:#4B0082;">แก้ไขโพสต์</h2>

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

    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded-4 shadow-sm" style="max-width:720px;margin:0 auto;">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label fw-semibold">ชื่อโพสต์</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $post->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label fw-semibold">เนื้อหา</label>
            <textarea name="content" id="content" rows="6" class="form-control" required>{{ old('content', $post->content) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label fw-semibold">รูปภาพ (ถ้ามี)</label>
            @if ($post->image)
                <div class="mb-2">
                    <img src="{{ asset('storage/'.$post->image) }}" alt="post image" class="rounded-3 shadow-sm" style="width:150px;height:150px;object-fit:cover;">
                </div>
            @endif
            <input type="file" name="image" id="image" class="form-control">
        </div>

        <div class="d-flex justify-content-center gap-2">
            <button type="submit" class="btn btn-primary px-4">💾 บันทึกการแก้ไข</button>
            <a href="{{ route('posts.show', $post->id) }}" class="btn btn-secondary px-4">ยกเลิก</a>
        </div>
    </form>
</div>
@endsection
