<div class="col-6 col-md-3 mb-4">
    <a href="{{ route('movies.show', $m) }}" class="text-decoration-none">
        <div class="card h-100">
            <img src="{{ $m->posterUrl() }}" class="card-img-top" alt="{{ $m->title }}">
            <div class="card-body p-2">
                <div class="fw-semibold text-truncate">{{ $m->title }}</div>
                <small class="text-secondary">{{ $m->year }} · {{ $m->type === 'bo' ? 'Phim bộ' : 'Phim lẻ' }}</small>
                @if($m->is_vip) <span class="badge badge-vip float-end">VIP</span> @endif
            </div>
        </div>
    </a>
</div>
