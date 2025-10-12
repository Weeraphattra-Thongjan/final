<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    
    <nav class ="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a href="#" class="navbar-brand">Wetalk </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" >
                <span class="navbar-toggler-iocn"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ route('index')}}"> หน้าแรก    </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"> หมวดหมู่ </a>
                    </li>
                        <form class="form-inline d-flex">
                            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">ค้นหา</button>
                        </form>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login')}}"> ลงชื่อเข้าใช้ / สมัครสมาชิก </a>
                    </li>
                </ul>
            </div>
        </div>

    </nav>

    <div class="container mt-5">
        @yield('content')
    </div>
    <footer class="bg-dark p-3 mt-5 text-white text-center">
        <p> website for eakapop </p>
    </footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" ></script>
</body>
</html>