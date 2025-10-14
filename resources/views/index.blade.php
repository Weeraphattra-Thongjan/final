@extends('layout')

@section('content')
    <h2>Welcome ชุมชน-ถามตอบ</h2>

    @auth
        <!-- ถ้าผู้ใช้เข้าสู่ระบบแล้ว แสดงปุ่มตั้งกระทู้ -->
        <a href="{{ route('create') }}" class="btn btn-primary mb-3">ตั้งกระทู้ของคุณเลย!</a>
    @else
        <!-- ถ้าผู้ใช้ยังไม่ได้เข้าสู่ระบบ แสดงลิงค์ให้เข้าสู่ระบบ -->
        <a href="{{ route('login') }}" class="btn btn-light mb-3">เข้าสู่ระบบเพื่อโพสต์</a>
    @endauth

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @else
        <div class="alert alert-info">ยังไม่มีโพสในระบบ</div>
    @endif

    @if ($posts->count())
        @foreach($posts as $post)
            <div class="post">
                <h3>{{ $post->title }}</h3>
                <p>{{ $post->content }}</p>
                <p><strong>โพสต์เมื่อ:</strong> {{ $post->created_at->format('d/m/Y H:i:s') }}</p>
                
                @if($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" alt="Home Image" width="100">
                @endif

                <!-- แสดงคอมเม้นต์จำกัดจำนวน -->
                <div class="comments">
                    <h4>คอมเมนต์:</h4>
                    @foreach($post->comments->take(3) as $comment) <!-- แสดงคอมเม้นต์ 3 ตัว -->
                        <p>{{ $comment->content }}</p>
                    @endforeach

                    <!-- ปุ่มเพื่อดูคอมเม้นต์ทั้งหมด -->
                    @if($post->comments->count() > 0)
                        <a href="{{ route('show', ['home' => $post->id]) }}" class="btn btn-secondary mt-2">ดูคอมเม้นต์ทั้งหมด</a>
                    @endif
                </div>

                <!-- ฟอร์มเพิ่มคอมเม้นต์ -->
                <form action="{{ route('comment.store', $post->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <textarea name="content" class="form-control mt-4" required></textarea>
                    <input type="file" name="image" class="form-control">
                    <button type="submit" class="btn btn-success mt-2">โพสต์คอมเม้นต์</button>
                </form>
            </div>
        @endforeach
    @else
        <div class="alert alert-info">ยังไม่มีโพสในระบบ</div>
    @endif
@endsection
