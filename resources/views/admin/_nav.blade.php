<ul class="nav nav-pills mb-4">
    @foreach([
        ['admin.dashboard', 'Tổng quan'],
        ['admin.movies.index', 'Phim'],
        ['admin.categories.index', 'Thể loại'],
        ['admin.users.index', 'Người dùng'],
        ['admin.comments.index', 'Bình luận'],
    ] as [$r, $label])
        <li class="nav-item"><a class="nav-link {{ request()->routeIs(str_replace('.index','.*',$r)) ? 'active' : 'text-light' }}" href="{{ route($r) }}">{{ $label }}</a></li>
    @endforeach
</ul>
