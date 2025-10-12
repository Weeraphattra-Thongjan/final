@extends('layout')

@section('content')
    <h2>Welcome ชุมชน-ถามตอบ</h2>

    @auth
        <!-- ถ้าผู้ใช้เข้าสู่ระบบแล้ว แสดงปุ่มตั้งกระทู้ -->
        <a href="{{ route('create')}}" class ="btn btn-primary mb-3"> ตั้งกระทู้ของคุณเลย! </a>

    @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @else
            <div class="alert alert-info">ยังไม่มีโพสในระบบ</div>
        @endif

    @else
        <!-- ถ้าผู้ใช้ยังไม่ได้เข้าสู่ระบบ แสดงลิงค์ให้เข้าสู่ระบบ -->
        <a href="{{ route('login') }}" class="btn btn-light mb-3">เข้าสู่ระบบเพื่อโพสต์</a>
    @endauth

    @if ($posts->count())
        @foreach ($posts as $post)
            <div class="card mb-5">
                <div class="card-body">
                    <h3>{{ $post->title}}</h3>
                    <p>{{ $post->content}}</p>
                    <a href="#" class="btn btn-secondary">View</a>
                    <a href="#" class="btn btn-warning">Edit</a>
                    <form action="#" method="POST" style="display: inline">
                        @csrf
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    @else
        <div class="alert alert-info">ยังไม่มีโพสในระบบ</div>
    @endif
@endsection
