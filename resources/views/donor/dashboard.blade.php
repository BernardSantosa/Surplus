@extends('layouts.donor')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        {{-- <h2>Hello, {{ Auth::user()->name }}! 👋</h2> --}}
        <h2>Hello, {{$user->name}}</h2>
        <p class="text-muted">Siap menyelamatkan makanan hari ini?</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('donor.food.create') }}" class="btn btn-primary btn-lg">+ Donasi Makanan</a>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card bg-light mb-3">
            <div class="card-body text-center">
                <h1 class="display-4 fw-bold text-success">{{ $totalDonated }}</h1>
                <p class="card-text">Total Donasi</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-light mb-3">
            <div class="card-body text-center">
                <h1 class="display-4 fw-bold text-primary">{{ $activeItems }}</h1>
                <p class="card-text">Item Tersedia</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-light mb-3">
            <div class="card-body text-center">
                <h1 class="display-4 fw-bold text-warning">{{ $totalClaims }}</h1>
                <p class="card-text">Permintaan Masuk</p>
            </div>
        </div>
    </div>
</div>

<div class="card mt-4 shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0">Riwayat Donasi Saya</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Foto</th>
                        <th>Nama Makanan</th>
                        <th>Jumlah</th>
                        <th>Exp. Date</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($foodItems as $item)
                    <tr>
                        <td>
                            @if($item->photo)
                                <img src="{{ asset('storage/' . $item->photo) }}" width="50" height="50" class="rounded object-fit-cover">
                            @else
                                <span class="badge bg-secondary">No IMG</span>
                            @endif
                        </td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->expires_at)->format('d M Y') }}</td>
                        <td>
                            <span class="badge {{ $item->status == 'available' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('donor.food.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('donor.food.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Belum ada makanan yang didonasikan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection