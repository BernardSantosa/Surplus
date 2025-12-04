@extends('layouts.receiver')

@section('content')

<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <h2>Mau makan apa hari ini? 😋</h2>
        <p class="text-muted">Temukan makanan gratis di sekitarmu.</p>
    </div>
</div>

<div class="card shadow-sm mb-5">
    <div class="card-body">
        <form action="{{ route('receiver.dashboard') }}" method="GET">
            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label fw-bold small">Cari Nama/Menu</label>
                    <input type="text" name="search" class="form-control" placeholder="Nasi goreng, Roti..." value="{{ request('search') }}">
                </div>
                
                <div class="col-md-3">
                    <label class="form-label fw-bold small">Kategori</label>
                    <select name="category_id" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-bold small">Lokasi</label>
                    <input type="text" name="location" class="form-control" placeholder="Jakarta..." value="{{ request('location') }}">
                </div>

                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Cari</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row">
    @forelse($foods as $food)
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm border-0 hover-shadow">
            @if($food->photo)
                <img src="{{ asset($food->photo) }}" class="card-img-top" alt="{{ $food->name }}">
            @else
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center text-muted">
                    <span>Tidak ada foto</span>
                </div>
            @endif

            <div class="card-body">
                <span class="badge bg-info text-dark mb-2">{{ $food->category->name }}</span>
                
                <h5 class="card-title fw-bold">{{ $food->name }}</h5>
                <p class="card-text text-muted small">
                    <i class="bi bi-geo-alt-fill"></i> {{ Str::limit($food->pickup_location, 30) }}
                </p>
                <p class="card-text">
                    {{ Str::limit($food->description, 60) }}
                </p>
            </div>
            
            <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center pb-3">
                <small class="text-muted">
                    Exp: {{ \Carbon\Carbon::parse($food->expires_at)->format('d M') }}
                </small>
                <a href="{{ route('receiver.food.show', $food->id) }}" class="btn btn-outline-primary btn-sm">
                    Lihat Detail
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="100" class="mb-3 opacity-50">
        <h4 class="text-muted">Belum ada makanan tersedia.</h4>
        <p>Coba ubah filter pencarianmu.</p>
        <a href="{{ route('receiver.dashboard') }}" class="btn btn-link">Reset Filter</a>
    </div>
    @endforelse
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $foods->appends(request()->query())->links('pagination::bootstrap-5') }}
</div>

@endsection