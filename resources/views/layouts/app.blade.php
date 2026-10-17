<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'PhimHay') - Website xem phim</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background:#0f172a; color:#e2e8f0; }
        .navbar { background:#1e293b; }
        .card { background:#1e293b; border:0; color:#e2e8f0; }
        .card img { aspect-ratio:2/3; object-fit:cover; }
        .table { --bs-table-bg:#1e293b; --bs-table-color:#e2e8f0; --bs-table-border-color:#334155; }
        .form-control, .form-select { background:#0f172a; color:#e2e8f0; border-color:#334155; }
        .form-control:focus, .form-select:focus { background:#0f172a; color:#e2e8f0; }
        a { text-decoration:none; }
        .badge-vip { background:#f59e0b; color:#000; }
        .pagination { --bs-pagination-bg:#1e293b; --bs-pagination-color:#e2e8f0; --bs-pagination-border-color:#334155; --bs-pagination-disabled-bg:#1e293b; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold text-warning" href="{{ route('home') }}">🎬 PhimHay</a>
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Trang chủ</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('movies.index') }}">Danh sách phim</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('vip.index') }}">Gói VIP</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Liên hệ</a></li>
            </ul>
            <form class="d-flex me-3" action="{{ route('movies.index') }}">
                <input class="form-control form-control-sm me-2" name="q" placeholder="Tìm phim..." value="{{ request('q') }}">
                <button class="btn btn-sm btn-warning">Tìm</button>
            </form>
            @auth
                <div class="dropdown">
                    <a class="btn btn-sm btn-outline-light dropdown-toggle" data-bs-toggle="dropdown">{{ auth()->user()->name }}</a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('account.profile') }}">Hồ sơ</a></li>
                        <li><a class="dropdown-item" href="{{ route('account.favorites') }}">Phim yêu thích</a></li>
                        <li><a class="dropdown-item" href="{{ route('account.history') }}">Lịch sử xem</a></li>
                        @if(auth()->user()->isAdmin())
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Trang quản trị</a></li>
                        @endif
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">@csrf
                                <button class="dropdown-item">Đăng xuất</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <a class="btn btn-sm btn-outline-light me-2" href="{{ route('login') }}">Đăng nhập</a>
                <a class="btn btn-sm btn-warning" href="{{ route('register') }}">Đăng ký</a>
            @endauth
        </div>
    </div>
</nav>

<main class="container pb-5">
    @if(session('ok')) <div class="alert alert-success">{{ session('ok') }}</div> @endif
    @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif
    @if($errors->any())
        <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
    @endif
    @yield('content')
</main>

<footer class="text-center text-secondary py-4 border-top border-secondary">
    © {{ date('Y') }} PhimHay - Đồ án website xem phim (Laravel + MySQL)
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
