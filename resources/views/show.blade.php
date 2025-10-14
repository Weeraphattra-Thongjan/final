@extends('layout')

@section('content')
    <h2>{{ $home->title }}</h2> <!-- ใช้ $home แทน $post -->
    <p>{{ $home->content }}</p> <!-- ใช้ $home แทน $post -->
    <p><strong>หมวดหมู่:</strong> {{ $home->category }}</p> <!-- ใช้ $home แทน $post -->

    <!-- แสดงวันเวลาโพสต์ -->
    <p><strong>โพสต์เมื่อ:</strong> {{ $home->created_at->timezone('Asia/Bangkok')->format('d/m/Y H:i:s') }}</p>

    <h3>คอมเม้นต์</h3>
    @foreach ($home->comments as $comment) <!-- ใช้ $home แทน $post -->
        <div>
            <strong>{{ $comment->user->name }}</strong> <!-- ผู้ที่ตอบ -->
            <p>{{ $comment->content }}</p>

            <!-- แสดงรูปที่เพิ่มในคอมเม้น -->
            @if ($comment->image)
                <img src="{{ asset('storage/' . $comment->image) }}" 
                     alt="Comment Image" 
                     width="200" 
                     class="rounded mb-2">
            @endif

             <!-- แสดงวันเวลาของคอมเมนต์ -->
            <p><small>โพสต์เมื่อ:</small> {{ $comment->created_at->timezone('Asia/Bangkok')->format('d/m/Y H:i:s') }}</p>
        </div>
    @endforeach

    <form action="{{ route('comment.store', $home) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <textarea name="content" class="form-control" rows="3" required></textarea>
        <input type="file" name="image" class="form-control mt-2">
        <button type="submit" class="btn btn-primary mt-2">เพิ่มคอมเม้นต์</button>
        <a href="{{ route ('index') }}" class="btn btn-secondary mt-2"> Back </a>
    </form>
@endsection
