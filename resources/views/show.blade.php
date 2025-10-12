@extends('layout')

@section('content')
    <h2>{{ $post->title }}</h2>
    <p>{{ $post->content }}</p>
    <p><strong>หมวดหมู่:</strong> {{ $post->category }}</p>

    <h3>คอมเม้นต์</h3>
    @foreach ($post->comments as $comment)
        <div>
            <strong>{{ $comment->user->name }}</strong>
            <p>{{ $comment->content }}</p>
        </div>
    @endforeach

    <form action="{{ route('storeComment', $post) }}" method="POST">
        @csrf
        <textarea name="content" class="form-control" rows="3" required></textarea>
        <button type="submit" class="btn btn-primary mt-2">เพิ่มคอมเม้นต์</button>
    </form>
@endsection
